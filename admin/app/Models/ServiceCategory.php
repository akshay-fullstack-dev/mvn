<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\MediaCollection;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class ServiceCategory extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    protected $table = 'service_category';

    protected $fillable = [
        'name',
        'description',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/service-categories/' . $this->getKey());
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('cover')
            ->accepts('image/*')
            ->maxNumberOfFiles(1)
            ->maxFilesize(10 * 1024 * 1024); // Set the file size limit

        $this->addMediaCollection('video')
            ->accepts('video/*')
            ->maxNumberOfFiles(5)
            ->maxFilesize(150 * 1024 * 1024); // Set the file size limit

        $this->addMediaCollection('gallery')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }

    public function registerMediaConversions($media = null)
    {
        $this->autoRegisterThumb200();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('cover');
    }
    public function processMedia(Collection $inputMedia): void
    {
        //First validate input
        // $this->getMediaCollections()->each(function ($mediaCollection) use ($inputMedia) {
        //     $this->validate(collect($inputMedia->get($mediaCollection->getName())), $mediaCollection);
        // });

        //Then process each media
        $this->getMediaCollections()->each(function ($mediaCollection) use ($inputMedia) {
            collect($inputMedia->get($mediaCollection->getName()))->each(function ($inputMedium) use (
                $mediaCollection
            ) {
                $this->processMedium($inputMedium, $mediaCollection);
            });
        });
    }
    public function processMedium(array $inputMedium, MediaCollection $mediaCollection): void
    {
        if (isset($inputMedium['id']) && $inputMedium['id']) {
            if ($medium = app(Media::class)->find($inputMedium['id'])) {
                if (isset($inputMedium['action']) && $inputMedium['action'] === 'delete') {
                    $medium->delete();
                } else {
                    $medium->custom_properties = $inputMedium['meta_data'];
                    $medium->save();
                }
            }
        } elseif (isset($inputMedium['action']) && $inputMedium['action'] === 'add') {
            $mediumFileFullPath = $inputMedium['path'];
            $this->addMediaFromUrl($mediumFileFullPath)
                ->withCustomProperties($inputMedium['meta_data'])
                ->toMediaCollection($mediaCollection->getName(), $mediaCollection->getDisk());
        }
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id');
    }
}
