<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Streets;
use Illuminate\Http\Request;

class StreetController extends Controller
{

    private $cityModel, $streetModel;
    public function __construct(City $city, Streets $street)
    {
        $this->cityModel = $city;
        $this->streetModel = $street;
    }

    public function street($id)
    {
        $streets = $this->streetModel::where('city_id', $id)->orderBy('id', 'DESC')->get();
        $city = $this->cityModel::find($id);
        return view('Admin.streets', compact('streets', 'city'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'city_id' => 'required|exists:cities,id',
            'lat' => 'required|string',
            'long' => 'required|string',
        ]);

        $this->streetModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'city_id' => $request->city_id,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return back()->with('done', 'تم اضافة الحي بنجاح');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'name_tr' => 'required|string|min:3|max:200',
            'street_id' => 'required|exists:streets,id',
            'lat' => 'required|string',
            'long' => 'required|string',
        ]);
        $city = $this->streetModel::find($request->street_id);

        $city->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return back()->with('done', 'تم تحديث الحي بنجاح');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'street_id' => 'required|exists:streets,id',
        ]);
        $city = $this->streetModel::find($request->street_id);

        $city->delete();

        return back()->with('done', 'تم حذف الحي بنجاح');
    }

    public function hideStreet(Request $request)
    {
        $request->validate([
            'street_id' => 'required|exists:streets,id',
        ]);
        $city = $this->streetModel::find($request->street_id);
        $city->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء الحي بنجاح');
    }
    public function showStreet(Request $request)
    {
        $request->validate([
            'street_id' => 'required|exists:streets,id',
        ]);
        $city = $this->streetModel::find($request->street_id);
        $city->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار الحي بنجاح');
    }
}
