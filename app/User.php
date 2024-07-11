<?php

namespace App;

use App\Enum\UserEnum;
use App\Http\Resources\v1\Auth\UserCollection;
use App\Http\Resources\v1\Auth\UserResource;
use App\Models\Booking;
use App\Models\OauthAccessToken;
use App\Models\PackageUserHistory;
use App\Models\Reason;
use App\Models\UserDocuments;
use App\Models\TempUserDocuments;
use App\Models\UserAddress;
use App\Models\UserOtp;
use App\Models\UserService;
use App\Models\UserTempAddress;
use App\Models\UserVehicles;
use App\Models\VendorLocation;
use App\Models\VendorRequestedService;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\User
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
 * @property-read \Illuminate\Database\Eloquent\Collection|OauthAccessToken[] $AuthAccessToken
 * @property-read int|null $auth_access_token_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Reason[] $rejection_reasons
 * @property-read int|null $rejection_reasons_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserDocuments[] $user_documents
 * @property-read int|null $user_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserOtp[] $user_otp
 * @property-read int|null $user_otp_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserTempAddress[] $user_temp_address
 * @property-read int|null $user_temp_address_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TempUserDocuments[] $user_temp_documents
 * @property-read int|null $user_temp_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserAddress[] $user_verified_address
 * @property-read int|null $user_verified_address_count
 * @property-read \Illuminate\Database\Eloquent\Collection|VendorRequestedService[] $vendor_requested_new_service
 * @property-read int|null $vendor_requested_new_service_count
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
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActiveShopCertifiedVendor($query)
    {
        return $query->activeVendor()->where('admin_user', UserEnum::admin_user);
    }
    public function scopeActiveVendor($query)
    {
        return $query->whereRole(UserEnum::user_vendor)->whereIs_blocked(UserEnum::not_blocked)->whereAccount_status(UserEnum::user_verified)->whereIs_offline(UserEnum::online)->where('stripe_connect_id', '!=', '0');
    }

    // scope
    public function scopeStripeConnected($query)
    {
        return $query->where('stripe_connect_id', '!=', '0');
    }
    // scope
    public function scopeOnline($query)
    {
        return $query->where('is_offline', UserEnum::online);
    }
    public function scopeActiveUser($query)
    {
        return $query->where('is_blocked', UserEnum::not_blocked);
    }

    public function AuthAccessToken()
    {
        return $this->hasMany(OauthAccessToken::class);
    }
    /**========================== set resource for use object =================================== */
    public function setResource($user)
    {
        return new UserResource($user);
    }
    public function setResources($user)
    {
        return new UserCollection($user);
    }


    // ************************************---------- Relationship data ------------------****************************************
    public function user_otp()
    {
        return $this->hasMany(UserOtp::class);
    }
    public function user_temp_documents()
    {
        return $this->hasMany(TempUserDocuments::class);
    }
    public function user_documents()
    {
        return $this->hasMany(UserDocuments::class);
    }

    // user temporary address
    public function user_temp_address()
    {
        return $this->hasMany(UserTempAddress::class);
    }
    // user permanent address
    public function user_verified_address()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function rejection_reasons()
    {
        return $this->hasMany(Reason::class)->where('type', UserEnum::document_rejected);
    }
    public function vendor_requested_new_service()
    {
        return $this->hasMany(VendorRequestedService::class);
    }

    public function vendor_services()
    {
        return $this->hasMany(UserService::class, 'user_id');
    }

    public function user_vehicles()
    {
        return $this->hasMany(UserVehicles::class, 'user_id');
    }

    public function vendor_bookings()
    {
        return $this->hasMany(Booking::class, 'vendor_id');
    }
    public function vendor_locations()
    {
        return $this->hasOne(VendorLocation::class);
    }
    public function user_packages(){
        return $this->hasMany(PackageUserHistory::class , 'user_id');
    }
    // ***********************************------------ End of relation ships ------------*****************************************
}
