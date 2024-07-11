<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',

            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'phone_number' => 'Phone number',
            'country_iso_code' => 'Country iso code',
            'is_blocked' => 'Is blocked',
            'account_status' => 'Account status',
            'country_code' => 'Country code',
            'created_at' => 'Created at',
            'action' => 'Action'

        ],
    ],

    'service' => [
        'title' => 'Services',

        'actions' => [
            'index' => 'Services',
            'create' => 'New Service',
            'edit' => 'Edit :name',
            'view' => 'View :name'
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'price' => 'Price',

        ],
    ],

    'user-document' => [
        'title' => 'User Documents',

        'actions' => [
            'index' => 'User Documents',
            'create' => 'New User Document',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'type' => 'Type',
            'name' => 'Name',
            'doc_number' => 'Doc number',
            'front_image' => 'Front image',
            'back_image' => 'Back image',

        ],
    ],

    'user-document' => [
        'title' => 'User Documents',

        'actions' => [
            'index' => 'User Documents',
            'create' => 'New User Document',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'document_name' => 'Document name',
            'document_number' => 'Document number',
            'front_image' => 'Front image',
            'back_image' => 'Back image',
            'document_type' => 'Document type',
            'document_status' => 'Document status',
            'message' => 'Message',

        ],
    ],

    'service' => [
        'title' => 'Services',

        'actions' => [
            'index' => 'Services',
            'create' => 'New Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'image' => 'Image',
            'price' => 'Price',

        ],
    ],

    'service' => [
        'title' => 'Services',

        'actions' => [
            'index' => 'Services',
            'create' => 'New Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'image' => 'Image',
            'price' => 'Price',
            'time' => 'Time',

        ],
    ],

    'service' => [
        'title' => 'Services',

        'actions' => [
            'index' => 'Services',
            'create' => 'New Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'price' => 'Price',

        ],
    ],

    'service' => [
        'title' => 'Services',

        'actions' => [
            'index' => 'Services',
            'create' => 'New Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'labour_price' => 'Labour Price',
            'approx_time' => 'Approx time',
            'category_name' => 'Service category',
            'spare_part' => 'Spare parts',
            'dealer_price' => 'Dealer Price',
            'spare_part_price' => 'Part Price',

        ],
    ],

    'vendor-requested-service' => [
        'title' => 'Vendor Requested Services',

        'actions' => [
            'index' => 'Vendor Requested Services',
            'create' => 'New Vendor Requested Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',

        ],
    ],

    'vendor-requested-service' => [
        'title' => 'Vendor Requested Services',

        'actions' => [
            'index' => 'Vendor Requested Services',
            'create' => 'New Vendor Requested Service',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'approx_time' => 'Approx time',
            'spare_parts' => 'Spare parts'

        ],
    ],

    'coupon' => [
        'title' => 'Coupons',

        'actions' => [
            'index' => 'Coupons',
            'create' => 'New Coupon',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'coupon_code' => 'Coupon code',
            'coupon_discount' => 'Coupon discount',
            'coupon_max_amount' => 'Coupon max amount',
            'coupon_min_amount' => 'Coupon min amount',
            'coupon_name' => 'Coupon name',
            'coupon_type' => 'Coupon type',
            'end_date' => 'End date',
            'maximum_per_customer_use' => 'Maximum per customer use',
            'maximum_total_use' => 'Maximum total use',
            'start_date' => 'Start date',
            'users_id' => 'Users',
            'coupon_description' => 'Coupon description'

        ],
    ],

    'delivery-charge' => [
        'title' => 'Delivery Charges',

        'actions' => [
            'index' => 'Delivery Charges',
            'create' => 'New Delivery Charge',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'customer_delivery_charge' => 'Customer delivery charge',
            'vendor_delivery_charge' => 'Vendor delivery charge',

        ],
    ],

    'booking' => [
        'title' => 'Bookings',

        'actions' => [
            'index' => 'Bookings',
            'create' => 'New Booking',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'order_id' => 'Order',
            'user_id' => 'User',
            'vendor_id' => 'Vendor',
            'service_id' => 'Service',
            'address_id' => 'Address',
            'payment_id' => 'Payment',
            'package_id' => 'Package',
            'vehicle_id' => 'Vehicle',
            'booking_start_time' => 'Booking start time',
            'booking_end_time' => 'Booking end time',
            'booking_status' => 'Booking status',
            'booking_type' => 'Booking type',
            'addition_info' => 'Addition info',
            'action' => 'Action'

        ],
    ],
    'booking_status' => [
        '0' => 'Booking Confirmed',
        '1' => 'Vendor assigned or vendor accepted',
        '2' => 'Vendor out for service',
        '3' => 'Vendor started job',
        '4' => 'Vendor job finished',
        '5' => 'Booking cancelled',
        '6' => 'Booking Rejected',
        '7' => 'Vendor reached location',
    ],

    'app-package' => [
        'title' => 'App Packages',

        'actions' => [
            'index' => 'App Packages',
            'create' => 'New App Package',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'bundle_id' => 'Bundle',
            'app_name' => 'App name',

        ],
    ],

    'app-version' => [
        'title' => 'App Versions',

        'actions' => [
            'index' => 'App Versions',
            'create' => 'New App Version',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'app_package_id' => 'App package',
            'app_bundle_id' => 'App Bundle',
            'force_update' => 'Force update',
            'message' => 'Message',
            'version' => 'Version',
            'code' => 'Code',
            'platform' => 'Platform',
            'category' => 'Service category'

        ],
    ],

    'service-category' => [
        'title' => 'Service Category',

        'actions' => [
            'index' => 'Service Category',
            'create' => 'New Service Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => "Image"

        ],
        'error' => [
            'service_category_cannot_be_delete' => 'Cannot delete this service. It has some service linked to this category.'
        ]
    ],

    'spare-parts-shop-location' => [
        'title' => 'Spare Parts Shop Locations',

        'actions' => [
            'index' => 'Spare Parts Shop Locations',
            'create' => 'New Spare Parts Shop Location',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'shop_name' => 'Shop name',
            'additional_shop_information' => 'Additional shop information',
            'country' => 'Country',
            'formatted_address' => 'Formatted address',
            'city' => 'City',
            'postal_code' => 'Postal code',
            'lat' => 'Lat',
            'long' => 'Long',

        ],
    ],

    'referral-amount' => [
        'title' => 'Referral Amounts',

        'actions' => [
            'index' => 'Referral Amounts',
            'create' => 'New Referral Amount',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'referral_amount' => 'Referral amount',

        ],
    ],
    'my_earing' => [
        'title' => "My Earning",
    ],

    'dispute' => [
        'title' => 'Disputes',

        'actions' => [
            'index' => 'Disputes',
            'create' => 'New Dispute',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'booking_id' => 'Booking Id',
            'user_name' => 'User Name',
            'user_id' => 'User Id',
            'user_email' => 'User Email',
            'message' => 'Message',
            'is_resolved' => 'Is resolved',

        ],
    ],

    'package' => [
        'title' => 'Packages',
        'id' => 'ID',
        'package_name' => 'Package Name',
        'order_id' => 'Order ID',
        'package_start_date' => 'Start Date',
        'package_end_date' => 'End Date',
        'user_name' => 'User Name',
        'action' => 'Action',
        'package_bookings' => "Package Booking",


        'actions' => [
            'index' => 'Packages',
            'create' => 'New Package',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'booking_gap' => 'Booking gap',
            'start_date' => 'Start date',
            'normal_price' => 'Normal Price',
            'dealer_price' => 'Dealer Price',
            'end_date' => 'End date',
            'no_of_times' => 'Number of Times',
            'no_of_times_placeholder' => 'Select Number of Booking Times',
            'select_service' => 'Select Package Service',
            'selected_service' => 'Selected Services',
            'sparepartdescription' => 'Spare Part Description'
        ],

    ],

    'package-maintain' => [
        'title' => 'Show Booked Packages',

        'actions' => [
            'index' => 'Package Maintains',
            'create' => 'New Package Maintain',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'package_id' => 'Package',
            'user_id' => 'User',
            'order_id' => 'Order',
            'transaction_id' => 'Transaction',
            'amount' => 'Amount',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
