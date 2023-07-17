<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\getLang;
use App\Models\About;
use Illuminate\Support\Facades\App;
use App\Models\Country;
use App\Models\travelCountry;
use App\Models\FrequentlryQuestions;
use App\Models\Info;
use App\Models\Privacy;
use App\Models\Social;
use App\Models\TermsAndConditions;
use App\Models\travelType;
use Illuminate\Http\Request;

class DataController extends Controller
{
    use GeneralTrait, getLang;

    private $countryModel, $appModel, $aboutModel, $infoModel, $socialModel, $termsModel, $questionsModel, $privecModel, $travelTypeModel, $travelCountryModel;

    public function __construct(Country $country, App $app, About $about, Info $info, Social $social, TermsAndConditions $terms, FrequentlryQuestions $questions, Privacy $privec, travelType $travelType, travelCountry $travel)
    {
        $this->countryModel = $country;
        $this->appModel = $app;
        $this->aboutModel = $about;
        $this->infoModel = $info;
        $this->socialModel = $social;
        $this->termsModel = $terms;
        $this->questionsModel = $questions;
        $this->privecModel = $privec;
        $this->travelTypeModel = $travelType;
        $this->travelCountryModel = $travel;
    }

    public function getCountres(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->countryModel::where('status', 1)->get(['id', 'name_ar', 'name_en', 'name_tr','code','flag']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                $data[$key]["code"] = $country->code;
                $data[$key]["flag"] = env('APP_URL') . 'Admin/images/country/' . $country->flag;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["countries" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getAccompanying(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'accompanyings'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["accompanyings" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function travel_country(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelCountryModel::where(['status' => 1, 'type' => 'travel'])->get(['id', 'name_ar', 'name_en', 'name_tr', 'image']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
                $data[$key]["image"] = env('APP_URL') . 'Admin/images/country/' . $country->image;
            }
            return $this->returnData("data", ["travelCountry" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function languages(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'language'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["languages" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function markiting_type(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'market'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["markitingType" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function travel_type(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'travel'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["travelType" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function event_type(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'event'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["eventType" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function gide_type(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $countries = $this->travelTypeModel::where(['status' => 1, 'type' => 'gide'])->get(['id', 'name_ar', 'name_en', 'name_tr']);
            foreach ($countries as $key => $country) {
                $data[$key]["id"] = $country->id;
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $country->name_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $country->name_tr;
                } else {
                    $data[$key]["name"] = $country->name_ar;
                }
            }
            return $this->returnData("data", ["gideType" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function info(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $info = $this->infoModel::get(['key', 'value']);
            return $this->returnData("data", ["info" => $info], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function socialMedia(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $socials = $this->socialModel::get(['key', 'value']);
            return $this->returnData("data", ["socials" => $socials], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function about(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $abouts = $this->aboutModel::get(['about_ar', 'about_en', 'about_tr']);
            foreach ($abouts as $key => $about) {
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $about->about_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $about->about_tr;
                } else {
                    $data[$key]["name"] = $about->about_ar;
                }
            }
            return $this->returnData("data", ["about" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function terms(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $terms = $this->termsModel::get(['term_ar', 'term_en', 'term_tr']);
            foreach ($terms as $key => $term) {
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $term->term_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $term->term_tr;
                } else {
                    $data[$key]["name"] = $term->term_ar;
                }
            }
            return $this->returnData("data", ["terms" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function questions(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $questions = $this->questionsModel::get(['title_ar', 'title_en', 'title_tr', 'answer_ar', 'answer_en', 'answer_tr']);
            foreach ($questions as $key => $question) {
                if ($request->header('lang') == "en") {
                    $data[$key]["title"] = $question->title_en;
                    $data[$key]["answer"] = $question->answer_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["title"] = $question->title_tr;
                    $data[$key]["answer"] = $question->answer_tr;
                } else {
                    $data[$key]["title"] = $question->title_ar;
                    $data[$key]["answer"] = $question->answer_ar;
                }
            }
            return $this->returnData("data", ["questions" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function privacies(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $privacies = $this->privecModel::get(['privace_ar', 'privace_en', 'privace_tr']);
            foreach ($privacies as $key => $about) {
                if ($request->header('lang') == "en") {
                    $data[$key]["name"] = $about->privace_en;
                } elseif ($request->header('lang') == "tr") {
                    $data[$key]["name"] = $about->privace_tr;
                } else {
                    $data[$key]["name"] = $about->privace_ar;
                }
            }
            return $this->returnData("data", ["privacies" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }
}
