<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Date;
use Illuminate\Http\Request;

class DateController extends Controller
{

    public function index()
    {
        $dates = Date::all();
        return view('Admin.date', compact('dates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|unique:dates,year',
        ]);
        Date::create([
            'year' => $request->year,
            'status' => '0',
        ]);
        return back()->with('done', 'تم اضافة التاريخ بنجاح');
    }

    public function update(Request $request)
    {
        $request->validate([
            'year' => 'required|unique:dates,year,' . $request->id,
        ]);
        Date::find($request->yearId)->update([
            'year' => $request->year,
        ]);
        return back()->with('done', 'تم تعديل التاريخ بنجاح');
    }

    public function delete(Request $request)
    {
        $x = Date::find($request->yearId);
        $x->delete();
        return back()->with('done', 'تم حذف التاريخ بنجاح');
    }

    public function hide(Request $request)
    {
        $year = Date::find($request->yearId);
        $year->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء الدولة بنجاح');
    }

    public function show(Request $request)
    {
        $year = Date::find($request->yearId);
        $year->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار الدولة بنجاح');
    }
}
