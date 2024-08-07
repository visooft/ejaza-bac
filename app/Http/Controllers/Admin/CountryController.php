<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\countryTrait;
use App\Http\Traits\ImagesTrait;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use countryTrait;
    use ImagesTrait;

    private $countryModel;

    public function __construct(Country $country)
    {
        $this->countryModel = $country;
    }

    public function country()
    {
        $countries = $this->getCountries();
        return view('Admin.countries', compact('countries'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'currency' => 'required|string|min:3|max:200',
            'code' => 'required|string|min:3|max:200|unique:countries,code',
            'flag' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileName = time() . '.' . $request->flag->extension();
        $this->uploadImage($request->flag, $fileName, 'countries');
        $this->countryModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'currency' => $request->currency,
            'code' => $request->code,
            'flag' => $fileName,
        ]);


        return back()->with('done', 'تم اضافة الدولة بنجاح');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'cityId' => 'required|exists:countries,id',
            'currency' => 'required|string|min:3|max:200',
            'code' => 'required|string|min:3|max:200|unique:countries,code,' . $request->cityId . ',id',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $city = $this->getCountryById($request->cityId);

        if ($request->hasFile('flag')) {
            $fileName = time() . '.' . $request->flag->extension();
            $oldpath = 'Admin/images/countries/' . $city->flag;
            $this->uploadImage($request->flag, $fileName, 'countries', $oldpath);
            $city->update([
                'flag' => $fileName,
            ]);
        }
        $city->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'currency' => $request->currency,
            'code' => $request->code,
        ]);

        return back()->with('done', 'تم تحديث الدولة بنجاح');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:countries,id',
        ]);
        $city = $this->getCountryById($request->cityId);
        $city->delete();

        return back()->with('done', 'تم حذف الدولة بنجاح');
    }

    public function hideCountry(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:countries,id',
        ]);
        $city = $this->getCountryById($request->cityId);
        $city->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء الدولة بنجاح');
    }

    public function showCountry(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:countries,id',
        ]);
        $city = $this->getCountryById($request->cityId);
        $city->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار الدولة بنجاح');
    }
}
