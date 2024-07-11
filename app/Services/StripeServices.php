<?php

namespace App\Services;

use App\Enum\NotificationEnum;
use App\Helpers\V1\PushNotificationHelper;
use App\Services\Interfaces\IStripeServices;
use App\Http\Requests\V1\Stripe\AddMoneyRequest;
use Auth;
use Exception;
use IntersoftStripe\Http\Services\StripePaymentProcess;

class StripeServices implements IStripeServices
{

	public function addMoney(AddMoneyRequest $request)
	{
		$user = Auth::user();
		$stripeProcess = new StripePaymentProcess();
		$stripe_record = $stripeProcess->intentPayment($request->amount, $request->card_id, $request->currency_code, $user);
		if (!$stripe_record)
			throw new Exception('cannot add money . Please try again later.');
		$money_added = $stripe_record->paid_amount - $stripe_record->stripe_charge;
		$user->wallet_money = $user->wallet_money + $money_added;
		$user->save();
		// SEND PUSH NOTIFICATION T THE USER
		$notification_title = trans('Api/v1/stripe.amount_added', ['value' => $money_added]);
		$notification_description = trans('Api/v1/stripe.total_amount', ['value' => $user->wallet_money]);
		PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $user->id, $notification_title, $notification_description, NotificationEnum::WALLET_MONEY_ADDED);
		return $user;
	}
}
