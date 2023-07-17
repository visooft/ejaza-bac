<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialsController extends Controller
{
    private $socialModel;
    public function __construct(Social $social)
    {
        $this->socialModel = $social;
    }

    public function socials()
    {
        $socials = $this->socialModel::orderBy('id', 'DESC')->get();
        return view('Admin.socials', compact('socials'));
    }
    public function store (Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'url' => 'required|url'
        ]);

        $this->socialModel::create([
            'key' => $request->key,
            'value' => $request->url
        ]);

        return back()->with('done', __('dashboard.addSocialMessage'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'socialId' => 'required|exists:socials,id',
            'key' => 'required|string',
            'url' => 'required|url'
        ]);
        $social = $this->socialModel::find($request->socialId);
        $social->update([
            'key' => $request->key,
            'value' => $request->url
        ]);

        return back()->with('done', __('dashboard.updateSocialMessage'));
    }
    public function delete (Request $request)
    {
        $request->validate([
            'socialId' => 'required|exists:socials,id',
        ]);
        $social = $this->socialModel::find($request->socialId);
        $social->delete();

        return back()->with('done', __('dashboard.deleteSocialMessage'));
    }
}
