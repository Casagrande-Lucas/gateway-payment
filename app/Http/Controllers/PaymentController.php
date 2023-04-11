<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Payer;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $dataPayment = $request->all();

        SDK::setAccessToken("TEST-2da1a4b3-6ce6-4044-b610-00718add9291");

        $payment = new Payment();
        $payment->transaction_amount = (float)$dataPayment['transactionAmount'];
        $payment->token = $dataPayment['token'];
        $payment->description = $dataPayment['description'];
        $payment->installments = (int)$dataPayment['installments'];
        $payment->payment_method_id = $dataPayment['paymentMethodId'];
        $payment->issuer_id = (int)$dataPayment['issuer'];

        $payer = new Payer();
        $payer->email = $dataPayment['email'];
        $payer->identification = array(
            "type" => $dataPayment['identificationType'],
            "number" => $dataPayment['identificationNumber']
        );
        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );
        echo json_encode($response);
    }
}
