<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accompagnement;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\ApiAdsTraits;
use App\Http\Traits\ApiSliderTraits;
use App\Http\Traits\ApiCityTraits;
use App\Http\Traits\ApiCategoryTrait;
use App\Http\Traits\getLang;
use App\Http\Traits\ImagesTrait;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AccompanimentController extends Controller
{
    use GeneralTrait, ApiAdsTraits, ApiSliderTraits, ApiCityTraits, ApiCategoryTrait, getLang, ImagesTrait;

    public function index(Request $request)
    {
        $lang = $this->returnLang($request);
        app()->setLocale($lang);
        try {
            $acc = Accompagnement::all();
            return $this->returnData('data', $acc, __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError('403', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $lang = $this->returnLang($request);
        app()->setLocale($lang);
        $request->validate([
            'title' => 'required|string|min:3|max:250',
        ]);
        $en = new GoogleTranslate('en');
        $tr = new GoogleTranslate('tr');
        try {
            $acc = Accompagnement::create([
                'title_ar' => $request->title,
                'title_en' => $en->translate($request->title),
                'title_tr' => $tr->translate($request->title),
            ]);
            return $this->returnData('data', $acc, __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError('403', $th->getMessage());
        }
    }

}
