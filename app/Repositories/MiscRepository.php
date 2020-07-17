<?php


namespace App\Repositories;


use App\Order;
use http\Exception;

class MiscRepository
{
    public function roundUp($number, $nearest){
        return $number + ($nearest - fmod($number, $nearest));
    }

    public function convertToPLN($price, $curr, $curr_sec){
        //$currency = USD / $currency = EUR itd...
        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$curr.'';
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response_object = json_decode($response_json);
                $base_price = $price; // Your price in USD
                return round(($base_price * $response_object->rates->$curr_sec), 2);
            }
            catch(Exception $e) {
                // Handle JSON parse error...
                return $e;
            }

        }else{
            return 'failed to catch response from api';
        }
    }

    public function getCountry()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);

        return $xml->geoplugin_countryCode;
    }

    public function test()
    {

    }
    public function getCurrency()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
        return dd($xml);
        return [$xml->geoplugin_currencyCode, $xml->geoplugin_continentCode];

    }

    public function prepare_order($desc, $email, $status, $payment, $warranty,$order_id, $price, $fee, $currency, $quantity)
    {

        Return Order::insert([
            'description' => $desc,
            'status' => $status,
            'email' => $email,
            'countrycode' => $this->getCountryCode(),
            'payment' => $payment,
            'warranty' => $warranty,
            'order_id' => $order_id,
            'price' => $price,
            'fee' => $fee,
            'currency' => $currency,
            'PLN' => $this->convertToPLN($price, $currency),
            'quantity' => $quantity,
        ]);
    }

}
