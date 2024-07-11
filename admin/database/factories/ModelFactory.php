<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'phone_number' => $faker->sentence,
        'country_iso_code' => $faker->sentence,
        'is_blocked' => $faker->boolean(),
        'account_status' => $faker->boolean(),
        'country_code' => $faker->sentence,
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Service::class, static function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,
        'image' => $faker->sentence,
        'price' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\UserDocument::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'type' => $faker->randomNumber(5),
        'name' => $faker->firstName,
        'doc_number' => $faker->sentence,
        'front_image' => $faker->sentence,
        'back_image' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\UserDocument::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'document_name' => $faker->sentence,
        'document_number' => $faker->sentence,
        'front_image' => $faker->sentence,
        'back_image' => $faker->sentence,
        'document_type' => $faker->boolean(),
        'document_status' => $faker->boolean(),
        'message' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Service::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'desc' => $faker->sentence,
        'image' => $faker->sentence,
        'price' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Service::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'desc' => $faker->sentence,
        'image' => $faker->sentence,
        'price' => $faker->sentence,
        'time' => $faker->time(),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Service::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'image' => $faker->sentence,
        'price' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'approx_time' => $faker->time(),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VendorRequestedService::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'price' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VendorRequestedService::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'price' => $faker->randomFloat,
        'approx_time' => $faker->time(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Coupon::class, static function (Faker\Generator $faker) {
    return [
        'coupon_code' => $faker->sentence,
        'coupon_discount' => $faker->randomFloat,
        'coupon_max_amount' => $faker->randomFloat,
        'coupon_min_amount' => $faker->randomFloat,
        'coupon_name' => $faker->sentence,
        'coupon_type' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'end_date' => $faker->dateTime,
        'maximum_per_customer_use' => $faker->randomNumber(5),
        'maximum_total_use' => $faker->randomNumber(5),
        'start_date' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'users_id' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DeliveryCharge::class, static function (Faker\Generator $faker) {
    return [
        'customer_delivery_charge' => $faker->randomFloat,
        'vendor_delivery_charge' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Booking::class, static function (Faker\Generator $faker) {
    return [
        'order_id' => $faker->sentence,
        'user_id' => $faker->sentence,
        'vendor_id' => $faker->sentence,
        'service_id' => $faker->sentence,
        'address_id' => $faker->sentence,
        'payment_id' => $faker->sentence,
        'package_id' => $faker->sentence,
        'vehicle_id' => $faker->sentence,
        'booking_start_time' => $faker->dateTime,
        'booking_end_time' => $faker->dateTime,
        'booking_status' => $faker->boolean(),
        'booking_type' => $faker->boolean(),
        'addition_info' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AppPackage::class, static function (Faker\Generator $faker) {
    return [
        'bundle_id' => $faker->sentence,
        'app_name' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AppVersion::class, static function (Faker\Generator $faker) {
    return [
        'app_package_id' => $faker->sentence,
        'force_update' => $faker->boolean(),
        'message' => $faker->sentence,
        'version' => $faker->randomFloat,
        'code' => $faker->sentence,
        'platform' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ServiceCategory::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SparePartsShopLocation::class, static function (Faker\Generator $faker) {
    return [
        'shop_name' => $faker->sentence,
        'additional_shop_information' => $faker->sentence,
        'country' => $faker->sentence,
        'formatted_address' => $faker->sentence,
        'city' => $faker->sentence,
        'postal_code' => $faker->sentence,
        'lat' => $faker->randomFloat,
        'long' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ReferralAmount::class, static function (Faker\Generator $faker) {
    return [
        'referral_amount' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Dispute::class, static function (Faker\Generator $faker) {
    return [
        'booking_id' => $faker->sentence,
        'user_id' => $faker->sentence,
        'message' => $faker->sentence,
        'is_resolved' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Package::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'status' => $faker->boolean(),
        'booking_gap' => $faker->randomNumber(5),
        'start_date' => $faker->dateTime,
        'end_date' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PackageMaintain::class, static function (Faker\Generator $faker) {
    return [
        'package_id' => $faker->randomNumber(5),
        'user_id' => $faker->randomNumber(5),
        'order_id' => $faker->sentence,
        'transaction_id' => $faker->sentence,
        'amount' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
