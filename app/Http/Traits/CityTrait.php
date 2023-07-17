<?php
namespace App\Http\Traits;

trait CityTrait{

    private function getCityById($cityId)
    {
        return $this->cityModel::find($cityId);
    }

    private function getCities($id)
    {
        $cities = $this->cityModel::where('country_id', $id)->orderBy('id', 'DESC')->get();
        return $cities;
    }
}
