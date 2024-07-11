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

	const USER_HOME_ADDRESS = 0;
	const USER_OFFICE_ADDRESS = 1;
	const USER_OTHER_ADDRESS = 2;
}
