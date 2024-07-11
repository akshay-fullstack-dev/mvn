<?php

namespace App\Enum;

class UserEnum
{

	// blocked user 
	const blocked_user = 1;
	const not_blocked = 0;

	// account status perimeters
	const no_action = 0;
	const verification_progress = 1;
	const user_verified = 2;
	const not_approved = 3;

	// user verified and not blocked
	const valid_user = 1;

	//user Roles
	const user_vendor = 1;
	const user_customer = 2;

	// need approval for the update user profile
	const is_approval_needed = true;

	// user reject reasons
	const user_blocked = 1;
	const document_rejected = 2;

	// values for the admin user if its true then then user is created from admin
	const no_admin_user = 0;
	const admin_user = 1;

	const offline = 1;
	const online = 0;

	// user login type
	const NORMAL_LOGIN = 0;
	const GMAIL_LOGIN = 1;
	const FACEBOOK_LOGIN = 2;
	const APPLE_LOGIN = 3;

	// vendor type
	const NORMAL_VENDOR = 1;
	const SHOP_CERTIFIED_VENDOR = 0;
	// SEARCHING AREA OF THE THE SHOP CERTIFIED VENDOR
	const SHOP_CERTIFIED_VENDOR_SEARCHING_AREA_IN_KM = 999999999;
	const NORMAL_VENDOR_SEARCHING_AREA_IN_KM = 10;
	const ITEM_PER_PAGE = 20;

	// wallet money constants
	const 	DEFAULT_USER_MONEY = 0;

	// user address type
	const USER_HOME_ADDRESS = 0;
	const USER_OFFICE_ADDRESS = 1;
	const USER_OTHER_ADDRESS = 2;

	// FOR TESTING PURPOSE SET THE STATIC VENDOR PRICE
	// const DELIVERY_CHARGE = 12;
	// const CUSTOMER_DELIVERY_CHARGE = 15;
	const SHOP_CERTIFIED_VENDOR_REQUEST = 0;
}
