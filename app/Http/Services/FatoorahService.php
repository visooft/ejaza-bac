<?php

namespace App\Http\Services;

class FatoorahService
{
    private $base_url;
    private $api_key;

    public function __construct()
    {
        $this->base_url = env('FATOORAH_BASE_URL');
        $this->api_key = env('FATOORAH_API_KEY');

    }

    private function buildRequest($endpointURL, $apiKey, $data = [], $requestType = "POST")
    {
        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die("Error: $error");
        }

        return json_decode($response);
    }

    public function sendPayment($data)
    {

        $response = $this->buildRequest('https://api.moyasar.com/v1/invoices', $this->api_key, $data);
        return $response;
    }

    public function getPaymentStatus($data)
    {
        return $this->buildRequest('https://api.moyasar.com/v1/invoices', $this->api_key, $data);

    }

    public static function handleError($response)
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }
}
