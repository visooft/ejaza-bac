<?php
namespace App\Http\Traits;

trait countryTrait{

    private function getCountryById($id)
    {
        return $this->countryModel::find($id);
    }

    private function getCountries()
    {
        $countries = $this->countryModel::orderBy('id', 'DESC')->get();
        foreach($countries as $country)
        {
            if (app()->getLocale() == "en") {
                $country->name = $country->name_en;
            }
            elseif (app()->getLocale() == "en") {
                $country->name = $country->name_tr;
            }
            else {
                $country->name = $country->name_ar;
            }
        }
        return $countries;
    }
}
