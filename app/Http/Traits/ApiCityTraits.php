<?php

namespace App\Http\Traits;

use Stichoza\GoogleTranslate\GoogleTranslate;

trait ApiCityTraits
{

    private function getCityById($cityId)
    {
        return $this->cityModel::find($cityId);
    }

    private function getCities($id)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $cityData = [];
        $cities = $this->cityModel::where('country_id', $id)->get();
        $key = 1;
        $cityData[0]['image'] = "";
        foreach ($cities as $city) {
            if (app()->getLocale() == "tr") {
                $city->name = $city->name_tr;
            } elseif (app()->getLocale() == "en") {
                $city->name = $city->name_en;
            } else {
                $city->name = $city->name_ar;
            }
            $city->image = env('APP_URL') . "Admin/images/cities/" . $city->image;
            $cityData[$key]['id'] = $city->id;
            $cityData[$key]['title'] = $city->name;
            $cityData[$key]['image'] = $city->image;
            $key++;
        }
        return $cityData;
    }


    private function getStreets($id)
    {
        $cityData = [];
        $streets = $this->streetModel::where('city_id', $id)->get();
        foreach ($streets as $key => $city) {
            if (app()->getLocale() == "tr") {
                $city->name = $city->name_tr;
            } elseif (app()->getLocale() == "en") {
                $city->name = $city->name_en;
            } else {
                $city->name = $city->name_ar;
            }
            $cityData[$key]['id'] = $city->id;
            $cityData[$key]['name'] = $city->name;
            $cityData[$key]['lat'] = $city->lat;
            $cityData[$key]['long'] = $city->long;
        }
        return $cityData;
    }
}
