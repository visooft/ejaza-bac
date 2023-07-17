<?php
namespace App\Http\Traits;

trait smsTrait
{
    public function _fireSMS($phone, $msg)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rest.gateway.sa/api/SendSMS?sms_type=T&encoding=T&api_id=API77027228436&api_password=Gateway@123&sender_id=Ejazah&phonenumber=$phone&V1=$msg&templateid=1586",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}?>