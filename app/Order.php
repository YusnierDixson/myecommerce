<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['recipient_name','line1','line2','city','country_code','state','postal_code',
    'email','shopping_cart_id','total','guide_number'];

public static function createFromPayPalResponse($paypalResponse, $shopping_cart){
  $payer = $paypalResponse->payer;

  $orderData = (array) $payer->payer_info->shipping_address;

  $orderData['email'] = $payer->payer_info->email;
  $orderData['total'] = $shopping_cart->amountInCents();
  $orderData['shopping_cart_id'] = $shopping_cart->id;

//Al coincidir los indices del arreglo con los campos de la tabla orders en muy facil almacenar
  return Order::create($orderData);
}

}
