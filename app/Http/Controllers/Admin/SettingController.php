<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ImagesTrait;
    private $settingModel;
    public function __construct(Setting $setting)
    {
        $this->settingModel = $setting;
    }

    public function settings()
    {
        $firebaseKey = $this->settingModel::where('key', 'firebaseKey')->first(['id','key', 'value']);
        $logo = $this->settingModel::where('key', 'webLogo')->first(['id','key', 'value']);
        $title = $this->settingModel::where('key', 'webName')->first(['id','key', 'value']);
        $smsSettings = $this->settingModel::where('key', '!=', 'firebaseKey')->get(['id','key', 'value']);

        $points = $this->settingModel::where('key', 'points')->first();
        $home = $this->settingModel::where('key', 'title')->first();
        $desc = $this->settingModel::where('key', 'desc')->first();
        $addition_value = $this->settingModel::where('key', 'addition_value')->first();

        return view('Admin.settings', compact('firebaseKey', 'smsSettings', 'logo', 'title', 'points', 'home', 'desc', 'addition_value'));
    }


    public function firebaseUpdate(Request $request)
    {
        $request->validate([
            'firebaseKey' => 'required',
        ]);
        $this->settingModel::where('key', 'firebaseKey')->update(['value' => $request->firebaseKey]);
        return back()->with('firebaseDone', __('dashboard.firebaseMessage'));
    }
    
    public function homw_desc(Request $request)
    {
        $request->validate([
            'desc' => 'required',
            'title' => 'required'
        ]);
        $this->settingModel::where('key', 'title')->update(['value' => $request->title]);
        $this->settingModel::where('key', 'desc')->update(['value' => $request->desc]);
        return back()->with('home', 'تم تعديل الوصف بنجاح');
    }
    
    public function addition_value(Request $request)
    {
        $request->validate([
            'addition_value' => 'required',
        ]);
        $this->settingModel::where('key', 'addition_value')->update(['value' => $request->addition_value]);
        return back()->with('addition_value', 'تم تعديل القيمة المضافة بنجاح');
    }
    
    public function smsUpdate(Request $request)
    {
        $request->validate([
            'MAIL_USERNAME' => 'required',
            'MAIL_PASSWORD' => 'required',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_HOST' => 'required',
        ]);

        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'MAIL_HOST='.env('MAIL_HOST'), 'MAIL_HOST='.$request->MAIL_HOST, file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_USERNAME='.$request->MAIL_USERNAME, file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_PASSWORD='.$request->MAIL_PASSWORD, file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'MAIL_FROM_ADDRESS='.env('MAIL_FROM_ADDRESS'), 'MAIL_FROM_ADDRESS='.$request->MAIL_FROM_ADDRESS, file_get_contents($path)
            ));
        }
        $this->settingModel::where('key', 'MAIL_USERNAME')->update(['value' => $request->MAIL_USERNAME]);
        $this->settingModel::where('key', 'MAIL_PASSWORD')->update(['value' => $request->MAIL_PASSWORD]);
        $this->settingModel::where('key', 'MAIL_FROM_ADDRESS')->update(['value' => $request->MAIL_FROM_ADDRESS]);
        $this->settingModel::where('key', 'MAIL_HOST')->update(['value' => $request->MAIL_HOST]);

        return back()->with('smsDone', __('dashboard.smsMessage'));
    }

    public function nameandLogo(Request $request)
    {
        $request->validate([
            'webName' => 'required|string|min:3|max:30',
            'webLogo' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);
        if ($request->webName) {
            $this->settingModel::where('key', 'webName')->update(['value' => $request->webName]);
        }
        if ($request->webLogo) {
            $logo = $this->settingModel::where('key', 'webLogo')->first();
            $imageName = time()  . '_logo.' . $request->webLogo->extension();
            // $oldImagePath = 'Admin/images/logo/' . $logo->value;

            $this->uploadImage($request->webLogo, $imageName, 'logo');
            $logo->update([
                'value' => $imageName
            ]);
        }
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'APP_NAME='.env('APP_NAME'), 'APP_NAME='.$request->webName, file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'LOGO='.env('LOGO'), 'LOGO='.$imageName, file_get_contents($path)
            ));
        }
        return back()->with('logoDone', __('dashboard.dataUpdate'));
    }

    public function points(Request $request)
    {
        $points = $this->settingModel::where('key', 'points')->first(['id','key', 'value']);
        $points->update(['value' => $request->points]);
        return back()->with('priceUpdate', 'تم تحديث عدد النقاط');
    }
}
