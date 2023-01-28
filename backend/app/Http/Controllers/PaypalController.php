<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Controllers\Controller;

use PayPal\Api\Plan;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\WebhookEvent;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret'))
        );
        $this->_api_context->setConfig(config('paypal'));
    }

    public function checkout(Request $request)
    {

        try {
            $payment = Payment::get($request->get('id'), $this->_api_context);
            return $payment;
        } catch (PayPalConnectionException $e) {
            return $e;
        }
    }
}
