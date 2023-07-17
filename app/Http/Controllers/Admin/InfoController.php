<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    private $infoModel;
    public function __construct(Info $info)
    {
        $this->infoModel = $info;
    }

    public function info()
    {
        $infos = $this->infoModel::orderBy('id', 'DESC')->get();
        return view('Admin.info', compact('infos'));
    }
    public function store (Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string'
        ]);

        $this->infoModel::create([
            'key' => $request->key,
            'value' => $request->value
        ]);

        return back()->with('done', __('dashboard.addInfoMessage'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'infoId' => 'required|exists:infos,id',
            'key' => 'required|string',
            'value' => 'required|string'
        ]);
        $info = $this->infoModel::find($request->infoId);
        $info->update([
            'key' => $request->key,
            'value' => $request->value
        ]);

        return back()->with('done', __('dashboard.updateInfoMessage'));
    }
    public function delete (Request $request)
    {
        $request->validate([
            'infoId' => 'required|exists:infos,id',
        ]);
        $info = $this->infoModel::find($request->infoId);
        $info->delete();

        return back()->with('done', __('dashboard.deleteInfoMessage'));
    }
}
