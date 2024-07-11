<?php

namespace IntersoftCoupon\Http\Controllers;

use IntersoftCoupon\Enum\CommonEnum;
use IntersoftCoupon\Enum\CouponEnum;
use IntersoftCoupon\Exceptions\RecordNotFoundException;
use IntersoftCoupon\Helpers\GeneralHelper;
use IntersoftCoupon\Http\Requests\GetCouponRequest;
use IntersoftCoupon\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use IntersoftCoupon\Http\Resources\CouponCollection;
use stdClass;

class CouponPackageController extends Controller
{
	private $lang_path = '';

	public function getCoupons(GetCouponRequest $request)
	{
		$item_per_page = $request->item_per_page ?? CouponEnum::PAGINATION_ITEM_PER_PAGE;
		$user = Auth::user();
		$all_coupons = Coupon::where('start_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now())
			->where(function ($query) use ($user) {
				$query->where('users_id', '=', null);
				$query->orWhere('users_id', '=', $user->id);
			})->with('coupon_history')->get();
		if (!$all_coupons->count() > 0)
			throw new RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		// filter the coupons
		$filtered = $all_coupons->reject(function ($coupon) use ($user) {
			if ($coupon->maximum_per_customer_use and $coupon->coupon_history()->where('user_id', $user->id)->count() >= $coupon->maximum_per_customer_use) {
				return true;
			}
			if ($coupon->maximum_total_use and $coupon->coupon_history()->count() >= $coupon->maximum_total_use)
				return true;
		});
		if (!$filtered->count() > 0)
			throw new RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		return Coupon::whereIn('id', $filtered->pluck('id')->toArray())->paginate($item_per_page);
	}

	public function add_coupons_to_users()
	{
		$arguments = func_num_args();
		if ($arguments == 0)
			return false;
		$user_ids = func_get_args();
		return Coupon::insert($this->addUserReferralCoupon($user_ids));
	}

	private function addUserReferralCoupon(array $user_ids)
	{
		$response = [];
		foreach ($user_ids as $id) {
			$response[] = [
				'coupon_name' => trans($this->lang_path . 'referral_coupon_name'),
				'coupon_code' => $this->getCouponCode(),
				'coupon_type' => CouponEnum::COUPON_TYPE_PERCENTAGE,
				'coupon_discount' => CouponEnum::COUPON_DISCOUNT_VALUE,
				'coupon_description' => trans($this->lang_path . 'referral_coupon_description'),
				'users_id' => $id,
				'coupon_min_amount' => CouponEnum::REFERRAL_COUPON_MIN_AMOUNT,
				'coupon_max_amount' => CouponEnum::REFERRAL_COUPON_MAX_AMOUNT,
				'maximum_total_use' => CouponEnum::MAXIMUM_REFERRAL_COUPON_USE,
				'maximum_per_customer_use' => CouponEnum::MAXIMUM_REFERRAL_COUPON_USE_PER_USER,
				'start_date' => Carbon::now(),
				'end_date' => Carbon::now()->addMonth(),
				'created_at' => Carbon::now()
			];
		}
		return $response;
	}

	private function getCouponCode()
	{
		while (true) {
			$user_coupon_code =	GeneralHelper::getCouponCode();
			$user_exist = Coupon::where(['coupon_code' => $user_coupon_code])->first();
			if (!$user_exist) {
				return $user_coupon_code;
			}
		}
	}
}
