<?php
//use DB;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Illuminate\Support\Collection;
use Brackets\Media\HasMedia\MediaCollection;
use Carbon\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $profile_picture
 * @property int|null $role 1Vendor2Customer
 * @property int $admin_user
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $phone_number
 * @property string $country_iso_code
 * @property int $is_blocked 0 no 1 yes
 * @property int $account_status 3not approved 2  verified 1under review0under review
 * @property int $is_offline 1:- offline, 0 :- online
 * @property string $country_code
 * @property string|null $profile_image
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $resource_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reason[] $reasons
 * @property-read int|null $reasons_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserTempAddress[] $tempAdd
 * @property-read int|null $temp_add_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TempUserDocument[] $tempDoc
 * @property-read int|null $temp_doc_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserTempInfo[] $tempInfo
 * @property-read int|null $temp_info_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $userAddresses
 * @property-read int|null $user_addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDocument[] $userDocuments
 * @property-read int|null $user_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserService[] $userServices
 * @property-read int|null $user_services_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdminUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsOffline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerModel extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    protected $table = 'users';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone_number',
        'country_iso_code',
        'is_blocked',
        'admin_user',
        'role',
        'account_status',
        'country_code',

    ];

    protected $hidden = [
        'remember_token',

    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',

    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/customer/' . $this->getKey());
    }
    ////////////////////////////////////////
    public function userDocuments()
    {
        return $this->hasMany('App\Models\UserDocument', 'user_id', 'id');
    }
    public function userServices()
    {
        return $this->hasMany('App\Models\UserService', 'user_id', 'id');
    }
    public function userAddresses()
    {
        return $this->hasMany('App\Models\UserAddress', 'user_id', 'id');
    }
    public function reasons()
    {
        return $this->hasMany('App\Models\Reason', 'user_id', 'id');
    }
    public function tempInfo()
    {
        return $this->hasMany('App\Models\UserTempInfo', 'user_id', 'id');
    }
    public function tempAdd()
    {
        return $this->hasMany('App\Models\UserTempAddress', 'user_id', 'id');
    }
    public function tempDoc()
    {
        return $this->hasMany('App\Models\TempUserDocument', 'user_id', 'id');
    }
    //////////////////////////////////////////

    public function registerMediaCollections()
    {

        $this->addMediaCollection('licence')
            ->accepts('image/*')
            ->maxNumberOfFiles(2);
        $this->addMediaCollection('education')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
        $this->addMediaCollection('other')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }
    public function registerMediaConversions($media = null)
    {
        $this->autoRegisterThumb200();
        $this->addMediaCollection('gallery');
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
            if ($medium = app(MediaModel::class)->find($inputMedium['id'])) {
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
    public function user_vehicles()
    {
        return $this->hasMany(UserVehicles::class, 'user_id');
    }
}
