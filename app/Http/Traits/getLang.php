<?php
namespace App\Http\Traits;

trait getLang{
    public function returnLang($request)
    {
        if ($request->header('lang') == 1) {
            $lang = "ar";
        } elseif ($request->header('lang') == 2) {
            $lang = "en";
        } elseif ($request->header('lang') == 3) {
            $lang = "tr";
        } else {
            $lang = "ar";
        }
        return $lang;
    }
}
