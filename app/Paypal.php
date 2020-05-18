<?php
namespace App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

use PayPal\Core\PayPalHttpClient;
use PayPal\v1\Payments\PaymentCreateRequest;
use PayPal\v1\Payments\PaymentExecuteRequest;
//Existe el ProductionEnvironment o el SandBoxEnvironment
use PayPal\Core\SandboxEnvironment;

class Paypal{
    public $client, $environment;

    public function __construct()
    {
        $clientid=Config::get('services.paypal.clientid');
        $secret=Config::get('services.paypal.secret');
        $this->environment=new SandBoxEnvironment($clientid,$secret);
        $this->client=new PayPalHttpClient($this->environment);

    }

    //Solicitud de cobro
    public function buildPaymentRequest($amount)
    {
       $request=new PaymentCreateRequest();
       $body=[
           "intent"=>"sale",
           "transactions"=>[
               [
                   "amount"=>["total"=>$amount,"currency"=>"USD"]
               ]
               ],
            "payer"=>[
                "payment_method"=>"paypal",
            ],
            "redirect_urls"=>[
                    "cancel_url"=>URL::route('shopping_cart.show'),
                    "return_url"=>URL::route('payments.execute')
            ]
        ];

        $request->body=$body;
        return $request;
    }

    public function charge($amount){
        return $this->client->execute($this->buildPaymentRequest($amount));
    }

    //Ejecución de cobros
    public function execute($paymentId,$payerId)
    {
        $paymentExecute=new PaymentExecuteRequest($paymentId);
        $paymentExecute->body=[
            "payer_id"=>$payerId
        ];
        return $this->client->execute($paymentExecute);
    }

}
