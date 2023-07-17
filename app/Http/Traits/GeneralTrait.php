<?php
namespace App\Http\Traits;

trait GeneralTrait{

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($errorNumber, $errorMessage)
    {
        return response()->json([
            'status' => false,
            'number' => $errorNumber,
            'message' => $errorMessage
        ]);
    }

    public function returnSuccessMessage($successMessage , $successNumber=1)
    {
        return response()->json([
            'status' => true,
            'number' => $successNumber,
            'message' => $successMessage
        ]);
    }

    public function returnSuccess($successNumber = 200, $successMessage = "")
    {
        return[
            'status' => true,
            'number' => $successNumber,
            'message' => $successMessage
        ];
    }

    public function returnData($key , $value , $message = "")
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            $key => $value
        ]);
    }
    
    public function returnErrorData($key , $value , $message = "")
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            $key => $value
        ]);
    }

    public function returnValidationError($code = "EOO1", $validator)
    {
        return $this->returnError($code,$validator->errors()->first());
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name") {
            return "E001";
        }
        elseif($input == "title"){
            return "E002";
        }
        elseif($input == "password"){
            return "E003";
        }
        elseif($input == "confirm_password"){
            return "E004";
        }
        elseif($input == "email"){
            return "E005";
        }
        elseif($input == "phone"){
            return "E006";
        }
        elseif($input == "address"){
            return "E007";
        }
        elseif($input == "country_id"){
            return "E008";
        }
        elseif($input == "street_id"){
            return "E009";
        }
        elseif($input == "otp"){
            return "E010";
        }
        elseif($input == "price"){
            return "E011";
        }
        elseif($input == "image"){
            return "E012";
        }
        elseif($input == "desc"){
            return "E013";
        }elseif($input == "time"){
            return "E014";
        }elseif($input == "day"){
            return "E015";
        }elseif($input == "area"){
            return "E016";
        }elseif($input == "lat"){
            return "E017";
        }elseif($input == "device_token"){
            return "E018";
        }
        elseif($input == "long"){
            return "E019";
        }
        elseif($input == "category_id"){
            return "E020";
        }
        elseif($input == "insurance"){
            return "E021";
        }
        elseif($input == "private_house"){
            return "E022";
        }
        elseif($input == "city_id"){
            return "E023";
        }
        elseif($input == "images"){
            return "E024";
        }
        elseif($input == "Shared_accommodation"){
            return "E025";
        }
        elseif($input == "animals"){
            return "E025";
        }
        elseif($input == "message_id"){
            return "E026";
        }
        elseif($input == "council"){
            return "E027";
        }elseif($input == "visits"){
            return "E028";
        }elseif($input == "kitchen_table"){
            return "E029";
        }elseif($input == "password_confirm"){
            return "E029";
        }elseif($input == "bed_room"){
            return "E029";
        }elseif($input == "Bathrooms"){
            return "E029";
        }
    }
}
