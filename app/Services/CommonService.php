<?php

namespace App\Services;

use App\Enum\CommonEnum;
use App\Exceptions;
use App\Services\Interfaces\ICommonService;
use App\Http\Requests\V1\Common\RaiseDisputeRequest;
use App\Models\Booking;
use App\Models\Dispute;
use App\Models\ReferralAmount;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommonService implements ICommonService
{
	private $lang_path = 'Api/v1/common.';
	public function getReferralPrice()
	{
		$referral = ReferralAmount::first();
		if (!$referral) {
			throw new Exceptions\RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		}
		return ['referral_amount' => $referral->referral_amount];
	}


	public function raiseDispute(RaiseDisputeRequest $request)
	{
		$auth_user = Auth::user();
		$status = Dispute::create($this->getReportData($request, $auth_user->id));
		if (!$status) {
			throw new Exceptions\InternalServerException(trans($this->lang_path . 'something_went_wrong'));
		}
		return trans($this->lang_path . 'success_report');
	}

	private function getReportData($request, $user_id)
	{
		return [
			'booking_id' => $request->booking_id,
			'message' => $request->message,
			'user_id' => $user_id,
			'ticket_id' => Str::random(8)
		];
	}
	public function getDispute(Request $request)
	{
		$item_per_page = $request->item_per_page ?? CommonEnum::PAGINATION_ITEM_PER_PAGE;
		$auth_user = Auth::user();
		$disputes = Dispute::where(['user_id' => $auth_user->id])->with(['booking.service']);
		// check for the booking id . If it is found then we need to filter according to booking
		if ($request->booking_id) {
			$disputes->where('booking_id', $request->booking_id);
		}
		$disputes = $disputes->paginate($item_per_page);
		if (!$disputes->count() > 0) {
			throw new Exceptions\RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		}
		return $disputes;
	}
}
