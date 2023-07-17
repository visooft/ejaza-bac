<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CityTrait;
use App\Http\Traits\ImagesTrait;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use CityTrait, ImagesTrait;
    private $cityModel, $countryModel;
    public function __construct(City $city, Country $country)
    {
        $this->cityModel = $city;
        $this->countryModel = $country;
    }

    public function cities ($id)
    {
        $cities = $this->getCities($id);
        $country = $this->countryModel::find($id);
        return view('Admin.cities', compact('cities', 'country'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'country_id' => 'required|exists:countries,id',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        $imageName = time() . '_city.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'cities');

        $this->cityModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'country_id' => $request->country_id,
            'image' => $imageName
        ]);

        return back()->with('done', __('dashboard.addCityMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'cityId' => 'required|exists:cities,id',
        ]);
        $city = $this->getCityById($request->cityId);
        if ($request->image) {
            $imageName = time() . '_city.' . $request->image->extension();
            $oldImagePath = 'Admin/images/cities/' . $city->image;

            $this->uploadImage($request->image, $imageName, 'cities', $oldImagePath);
        } else {
            $imageName = $city->image;
        }

        $city->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName
        ]);

        return back()->with('done', __('dashboard.updateCityMessage'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:cities,id',
        ]);
        $city = $this->getCityById($request->cityId);
        if ($city->image) {
            $imageUrl = "Admin/images/cities/" . $city->image;
            unlink(public_path($imageUrl));
        }
        $city->delete();

        return back()->with('done', __('dashboard.delteCityMessage'));
    }

    public function hideCity(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:cities,id',
        ]);
        $city = $this->getCityById($request->cityId);
        $city->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء المدينة بنجاح');
    }
    public function showCity(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:cities,id',
        ]);
        $city = $this->getCityById($request->cityId);
        $city->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار المدينة بنجاح');
    }
}
