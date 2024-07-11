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
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\Models\Media;


/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $approx_time
 * @property-read mixed $resource_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceInclusion[] $serviceInclusion
 * @property-read int|null $service_inclusion_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereApproxTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model implements HasMedia
{
    use SoftDeletes;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    protected $fillable = [
        'name',
        'description',
        'price',
        'approx_time',
        'service_category_id',
        'spare_parts',
        'spare_part_price',
        'dealer_price'

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/services/' . $this->getKey());
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
    // relationships
    public function service_categories()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
