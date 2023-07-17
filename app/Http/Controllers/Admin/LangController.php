<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function set($lang)
    {
        $languages = ['en', 'ar'];
        if (!in_array($lang, $languages)) {
            $lang = "ar";
        }
        session()->put('lang', $lang);

        return back();
    }
}
