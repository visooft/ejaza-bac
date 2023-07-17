<?php
namespace App\Http\Traits;

trait paymentTrait{
    
    public function payment($data, $url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer sk_test_6aBoM8bZdsVKSTVrrH3nPXZcYyS5qrfbTpZ6fpsx'
            )
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
        
    }
}