<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\MediaCollection;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Package extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    protected $fillable = [
        'name',
        'description',
        'status',
        'booking_gap',
        'start_date',
        'end_date',
        'no_of_times',
        'normal_price',
        'dealer_price',
        'sparepartdescription'
    ];


    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'view_package_booking'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/packages/' . $this->getKey());
    }
    public function getViewPackageBookingAttribute()
    {
        return url('admin/packages/bookings/' . $this->getKey());
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('cover')
            ->accepts('image/*')
            ->maxNumberOfFiles(5)
            ->maxFilesize(10 * 1024 * 1024); // Set the file size limit

        $this->addMediaCollection('video')
            ->accepts('video/*')
            ->maxNumberOfFiles(5)
            ->maxFilesize(150 * 1024 * 1024); // Set the file size limit

        $this->addMediaCollection('gallery')
            ->accepts('image/*')
            ->maxNumberOfFiles(20);

        $this->addMediaCollection('pdf')
            ->accepts('application/pdf');
    }

    public function registerMediaConversions($media = null)
    {
        $this->autoRegisterThumb200();
        $this->addMediaCollection('gallery');
    }
    public function serviceInclusion()
    {
        return $this->hasMany('App\Models\ServiceInclusion', 'service_id', 'id');
    }


    public static function bootHasMediaCollectionsTrait(): void
    {
        static::saving(static function ($model) {
            $model->processMedia(collect(request()->only($model->getMediaCollections()->map->getName()->toArray())));
        });
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
    public function package_services()
    {
        return $this->hasMany(PackageService::class, 'package_id');
    }

    public function packageMaintains()
    {
        return $this->hasMany('App\Models\PackageMaintain');
    }
    public function purchased_package()
    {
        return $this->hasMany(PackageUserHistory::class, 'package_id');
    }
}
