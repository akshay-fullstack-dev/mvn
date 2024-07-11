<?php

namespace IntersoftStripe\Http\Services;

use App\User;
use Config;
use Exception;
use IntersoftStripe\Http\Models\Stripe_payment_record;
use \Stripe\Transfer;
use \Stripe\StripeClient;

class StripePaymentProcess
{
	private $stripe_secret_key;
	// set stripe key to the package
	public function __construct()
	{
		$stripe_secret_key = env('STRIPE_SECRET_KEY');
		if (!$stripe_secret_key)
			throw new Exception("Internal server error .Error with payment gateway", 500);

		\Stripe\Stripe::setApiKey($stripe_secret_key);
		$this->stripe_secret_key = $stripe_secret_key;
	}

	/**
	 * make a indent payment for the stripe
	 */
	public function intentPayment($stripe_total_pay, $card_id, $currency_code, $user)
	{
		$paymentIntent = \Stripe\PaymentIntent::create([
			'amount' => $stripe_total_pay * 100,
			'currency' => $currency_code,
			'payment_method_types' => ['card'],
			'source' => $card_id,
			'customer' => $user->stripe_customer_id,
			'confirmation_method' => 'automatic',
			'confirm' => true
		]);
		if (!$paymentIntent)
			return false;
		return	$this->save_history($paymentIntent, $currency_code, $user->id);
		// return the stripe response
	}


	private function save_history($paymentIntent, $currency_code, $user_id)
	{
		// save the payment history of the stripe
		$paid_amount =  $paymentIntent->amount / 100;
		$stripe_record = new Stripe_payment_record;
		$stripe_record->payment_intent_id = $paymentIntent->id;
		$stripe_record->user_id = $user_id;
		$stripe_record->charge_id = $paymentIntent->charges->data[0]->id;
		$stripe_record->currency_code = $currency_code;
		$stripe_record->user_stripe_id = $paymentIntent->customer;
		$stripe_record->paid_amount = $paid_amount;
		$stripe_record->card_id = $paymentIntent->source;
		$stripe_record->stripe_charge = $this->get_stripe_fees($currency_code, $paid_amount);
		$stripe_record->save();
		return $stripe_record;
	}

	/**
	 * transfer payment to the another user
	 */
	public function transferCharges($transferAmount, $transferTo, $payment_id)
	{
		// $payment_history =	$this->get_stripe_payment_history($payment_id);
		// if (!$payment_history)
		// 	return false;
		// Create a Transfer to a connected account (later):
		$transfer = Transfer::create([
			'amount' => $transferAmount * 100,
			'currency' => 	'usd',
			'destination' => $transferTo,
		]);
		if ($transfer)
			return $transfer;
		return false;
	}

	// refund the payment 
	public function refund_payment($payment_id, $refund_amount = null)
	{
		$stripe_payment = Stripe_payment_record::where('payment_id', $payment_id)->first();
		if ($stripe_payment) {
			if ($refund_amount != null)
				$refund_object['amount'] = $refund_amount * 100;
			$refund_object = ['charge' => $stripe_payment->charge_id];
			$stripe = new StripeClient($this->stripe_secret_key);
			$charge = $stripe->charges->retrieve($stripe_payment->charge_id);
			$refund = false;
			if ($charge->refunded == true)
				$refund = true;
			else {
				$status =	$stripe->refunds->create($refund_object);
				if ($status)
					$refund = true;
			}
			return $refund;
		}
		return false;
	}
	public function updateHistoryTable($charge_id, $payment_id)
	{
		$history = Stripe_payment_record::where('charge_id', $charge_id)->first();
		if ($history) {
			$history->payment_id = $payment_id;
			return $history->save();
		}
		return false;
	}

	public function get_stripe_payment_history($payment_id)
	{
		return Stripe_payment_record::where('payment_id', $payment_id)->first();
	}

	private function get_stripe_fees($currency, $total_price)
	{
		$currency = strtolower($currency);
		$currency_price = Config::get("stripe_fees.$currency");
		if (!$currency_price)
			return Config::get("stripe_fees.default");
		$service_charge = ($total_price * ($currency_price['percentage'] / 100)) + $currency_price['fixed'];
		return $service_charge;
	}
}
