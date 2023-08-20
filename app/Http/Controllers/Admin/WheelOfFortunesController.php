<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WheelOfFortune;
use Illuminate\Http\Request;

class WheelOfFortunesController extends Controller
{
    private $wheel_of_fortunesModel;
    public function __construct(WheelOfFortune $wheel)
    {
        $this->wheel_of_fortunesModel = $wheel;
    }
    public function wheel_of_fortunes()
    {
        $wheels = $this->wheel_of_fortunesModel::orderBy('id', 'DESC')->get();

        return view('Admin.wheels', compact('wheels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        $this->wheel_of_fortunesModel::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return back()->with('done', 'تم اضافة القيمة بنجاح');
    }

    public function update(Request $request)
    {
        $request->validate([
            'infoId' => 'required|exists:wheel_of_fortunes,id',
            'key' => 'required|string',
            'value' => 'required|string',
        ]);
        $wheel = $this->wheel_of_fortunesModel::findOrFail($request->infoId);
        $wheel->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return back()->with('done', 'تم تحديث القيمة بنجاح');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'infoId' => 'required|exists:wheel_of_fortunes,id',
        ]);
        $wheel = $this->wheel_of_fortunesModel::findOrFail($request->infoId);
        $wheel->delete();

        return back()->with('done', 'تم حذف القيمة بنجاح');
    }

    public function hide(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:wheel_of_fortunes,id',
        ]);

        $slider = $this->wheel_of_fortunesModel::findOrFail($request->sliderId);
        $slider->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء الاضافة');
    }
    public function show(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:wheel_of_fortunes,id',
        ]);

        $slider = $this->wheel_of_fortunesModel::findOrFail($request->sliderId);
        $slider->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار الاضافة');
    }
}
