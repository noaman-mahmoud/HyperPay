<?php

namespace NoamanMahmoud\HyperPay;

class HyperPay {

    /**  public function get EntityId . */
    public static function getEntityId($brand)
    {
        $entities = config('hyperpay.entities');

        if (!array_key_exists($brand, $entities))
        {
            throw new \Exception('brand not Found');
        }

        return $entities[$brand];
    }

    /**  public function get Url . */
    public static function getUrl()
    {
        if (!in_array(config('hyperpay.mode') , ['test','live']) )
        {
            throw new \Exception('hyperpay mode is [test] or [live]');
        }

        if (config('hyperpay.mode') == 'test'){

            $url = "https://test.oppwa.com/v1/checkouts";

        }else{

            $url = "https://oppwa.com/v1/checkouts";
        }

        return $url;
    }

    /**  public function get Information . */
    public static function getInformation($dataInfo = [])
    {
        $info = empty($dataInfo) ? config('hyperpay.information') : $dataInfo;

        $parameters =
            "&currency=".config('hyperpay.currency').
            "&merchantTransactionId=".rand(1111,9999).'_'.rand().
            "&customer.email=".$info['customer.email'].
            "&billing.street1=".$info['billing.street1'].
            "&billing.city=".$info['billing.city'].
            "&billing.state=".$info['billing.state'].
            "&billing.country=".$info['billing.country'].
            "&billing.postcode=".$info['billing.postcode'].
            "&customer.givenName=".$info['customer.givenName'].
            "&customer.surname=".$info['customer.surname'].
            "&testMode=EXTERNAL".
            "&createRegistration=true".
            "&paymentType=DB";

        if (config('hyperpay.mode') == 'live'){

            $data = str_ireplace("&testMode=EXTERNAL","",$parameters);
        }else{
            $data = $parameters;
        }

        return $data;
    }

    /**  public function checkout Hyper Pay . */
    public static function checkoutHyperPay($price = "" , $brand = "" , $dataInfo = [])
    {
        if (empty($price))
        {
            throw new \Exception('pleas set amount to checkout HyperPay ');
        }

        if (empty($brand))
        {
            throw new \Exception('pleas set brand to checkout HyperPay ');
        }

        $data = "entityId=".self::getEntityId($brand)."&amount=".$price.self::getInformation($dataInfo);

        global $response;

        $ch  = curl_init();
        $SSL = config('hyperpay.mode') == "test" ? false : true;

        curl_setopt($ch, CURLOPT_URL, self::getUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.config('hyperpay.token')]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,$SSL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if(curl_errno($ch)) return curl_error($ch);

        curl_close($ch);

        return json_decode($response);
    }

    /**  public function transaction Id . */
    public static function transactionId()
    {
        global $response; $data = json_decode($response);

        return $data->id;
    }

    /**  public function payment Status . */
    public static function paymentStatus($transactionId, $brand)
    {
        if (empty($transactionId))
        {
            throw new \Exception('pleas set transactionId HyperPay ');
        }

        $mode = config('hyperpay.mode') == 'test' ? "test." : '';

        $url  = "https://{$mode}oppwa.com/v1/checkouts/{$transactionId}/payment";
        $url .= "?entityId=".self::getEntityId($brand);

        $ch  = curl_init();
        $SSL = config('hyperpay.mode') == "test" ? false : true;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.config('hyperpay.token')]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $SSL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {

            return curl_error($ch);
        }

        curl_close($ch);

        $json = json_decode($response, true);

        $code = $json['result']['code'];

        $description  = $json['result']['description'];

        if ( self::success($code) ){

            $data = ['status' => 'success' , 'description'=> $description ];

        }else{

            $data = ['status' => 'fail' , 'description'=> $description ];
        }

        return $data;
    }

    /**  public function success . */
    public static function success($code)
    {
        $codePattern   = '/^(000\.000\.|000\.100\.1|000\.[36])/';
        $manualPattern = '/^(000\.400\.0|000\.400\.100)/';

        $successCodes  = [
            '000.000.000',
            '000.000.100',
            '000.100.110',
            '000.100.111',
            '000.100.112',
            '000.300.000',
            '000.300.100',
            '000.300.101',
            '000.300.102',
            '000.600.000',
            '000.200.100'
        ];

        if ( preg_match($codePattern, $code) || preg_match($manualPattern, $code)){

            return  true;

        }else if (in_array( $code, $successCodes )){

            return  true;

        }else{
            return false;
        }
    }
}
