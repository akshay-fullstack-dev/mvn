<?php

namespace IntersoftStripe\Http\Controllers;

use  IntersoftStripe\Exceptions\BadRequestException;
use  IntersoftStripe\Exceptions\SomeThingWentWrong;
use  IntersoftStripe\Exceptions\SuccessException;
use  IntersoftStripe\Exceptions\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use IntersoftStripe\Exceptions\StripeSomeThingWentWrong;

/*
|--------------------------------------------------------------------------
| Register Controller
|--------------------------------------------------------------------------
|
| This controller is used for stripe apis like
| check driver stripe account linked or not, Link stripe account
| create customer, create card
|
*/

class StripeController extends Controller
{
    protected $response = [
        'status' => 0,
        'message' => '',
        'data' => array()
    ];

    public function __construct()
    {
        $stripe_api_key = env('STRIPE_SECRET_KEY');
        if ($stripe_api_key)
            \Stripe\Stripe::setApiKey($stripe_api_key);
        else
            throw new BadRequestException('payment key not set');
    }

    /**
     * Check user stripe account linked.
     *
     * @param Request $request
     * @return json  $response
     */

    public function accountLinked()
    {
        $user = Auth::user();
        if ($user->stripe_connect_id) {
            $message = "Your account linked to the stripe";
            $code = 200;
        } else {
            $message = "Account not linked with stripe";
            $code = 402;
        }
        throw new SuccessException($message, [], $code);
    }

    /**
     * connect stripe account.
     *
     * @param Request $request
     * @return json  $response
     */
    public function linkAccount(Request $request)
    {
        $user = Auth::user();
        $code = 200;
        if ($user->stripe_connect_id) {
            $message = "Your account linked to the stripe";
            throw new SuccessException($message, [], $code);
        } else {
            $this->response['status'] = $code;
            $validator = Validator::make($request->all(), [
                'token_account' => 'required'
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator->errors()->first());
            }
            try {
                $token = $request['token_account'];
                $account = \Stripe\OAuth::token([
                    'grant_type' => 'authorization_code',
                    'code' => $token,
                ]);
                if ($account) {
                    $user->stripe_connect_id = $account->stripe_user_id;
                    $user->save();
                } else {
                    throw new Exception('Cannot link your account with stripe');
                }
                throw new SuccessException('Successfully connected to stripe');
            } catch (SuccessException $e) {
                throw new SuccessException('Successfully connected to stripe');
            } catch (Exception $ex) {
                throw new SomeThingWentWrong($ex->getMessage());
            }
        }
    }

    /**
     * check customer created.
     *
     * @param Request $request
     * @return json  $response
     */
    public function customerExists(Request $request)
    {
        $user = Auth::user();
        if ($user->stripe_customer_id) {
            throw new SuccessException(
                trans('stripe::common.you_connected_to_strip'),
                [
                    'customerId' => $user->stripe_customer_id
                ]
            );
        } else {
            throw new SuccessException(
                trans('stripe::common.not_connected_to_strip'),
                [
                    'customerId' => ''
                ],
                400
            );
        }
    }

    /**
     * create customer if not created and create card under that.
     *
     * @param Request $request
     * @return json  $response
     */
    public function createCustomer(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'token_card' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->first());
        }

        $customer = $user->stripe_customer_id;
        if (!$customer) {
            try {
                $customerObj = \Stripe\Customer::create([
                    'description' => $user->name . '(' . $user->email . ')',
                ]);
                $customer = $customerObj->id;
                $user->stripe_customer_id = $customer;
                $user->save();
            } catch (\Exception $e) {
                throw new StripeSomeThingWentWrong(trans($e->getMessage()));
            }
        }

        $card_token = $request['token_card'];

        if ($customer) {
            try {
                $card = \Stripe\Customer::createSource(
                    $customer,
                    ['source' => $card_token]
                );
            } catch (\Exception $e) {
                throw new StripeSomeThingWentWrong(trans($e->getMessage()));
            }
        }
        throw new SuccessException('Card created successfully', ['customerId' => $user->stripe_customer_id]);
    }
}
