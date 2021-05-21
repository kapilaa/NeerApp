<?php

namespace App\Billing;
use Illuminate\Support\Str;

class PaymentGateway{

    private $currency;


    public function _contruct($currency){

        $this->currency=$currency;
    }

    public function charge($amount){


        return [
            "amount"=>$amount,
            "confirmation_number"=>Str::orderedUuid(),
            "currency"=>$this->currency,
        ];

    }



}

