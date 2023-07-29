<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiAdsTraits;
use App\Http\Traits\ApiSliderTraits;
use App\Http\Traits\ApiCityTraits;
use App\Http\Traits\ApiCategoryTrait;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\getLang;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\City;
use App\Models\Comments;
use App\Models\Date;
use App\Models\Favourites;
use App\Models\HouseDetials;
use App\Models\HouseTerms;
use App\Models\Housing;
use App\Models\Images;
use App\Models\Notifications;
use App\Models\NotificationsDetials;
use App\Models\Offers;
use App\Models\Order;
use App\Models\Travel;
use App\Models\travelCountry;
use App\Models\TravelImages;
use App\Models\TravelTerms;
use App\Models\travelType;
use App\Models\Sliders;
use App\Models\Adspace;
use App\Models\Streets;
use App\Models\Setting;
use App\Models\User;
use App\Models\userDetials;
use App\Models\Wallet;
use App\Models\WheelOfFortune;
use App\Models\WheelUsers;
use Carbon\Carbon;
use App\Models\Accompanying;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Http\Request;
use App\Models\Splach;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class HomeScreenController extends Controller
{
    use GeneralTrait, getLang, ApiSliderTraits, ApiCategoryTrait, ApiCityTraits, ImagesTrait, ApiAdsTraits;

    private $appModel, $sliderModel, $categoryModel, $spaceModel, $cityModel, $validateModel, $detialModel, $termModel, $houseModel, $imageModel, $streetModel, $userDetiaslModel, $carbonModel, $commenetModel, $favouriteModel, $wheelModel, $TravelTermsModel, $travelImageModel, $travelModel, $travelCountryModel, $travelTypeModel;

    public function __construct(App $app, Sliders $slider, Category $category, City $city, Validator $validate, Housing $house, HouseTerms $term, HouseDetials $detials, Images $image, Streets $street, userDetials $userDetiasl, Carbon $carbon, Comments $commenet, Favourites $favourite, WheelOfFortune $wheel, travelType $travelType, travelCountry $travelCountry, Travel $travel, TravelImages $travelImage, TravelTerms $TravelTerms, Adspace $space, Splach $splach)
    {
        $this->appModel = $app;
        $this->spaceModel = $space;
        $this->sliderModel = $slider;
        $this->categoryModel = $category;
        $this->cityModel = $city;
        $this->validateModel = $validate;
        $this->houseModel = $house;
        $this->termModel = $term;
        $this->detialModel = $detials;
        $this->imageModel = $image;
        $this->streetModel = $street;
        $this->userDetiaslModel = $userDetiasl;
        $this->carbonModel = $carbon;
        $this->commenetModel = $commenet;
        $this->favouriteModel = $favourite;
        $this->wheelModel = $wheel;
        $this->TravelTermsModel = $TravelTerms;
        $this->travelImageModel = $travelImage;
        $this->travelModel = $travel;
        $this->travelCountryModel = $travelCountry;
        $this->travelTypeModel = $travelType;
        $this->splachModel = $splach;
    }

    public function homeScreen(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $sliders = $this->getSliders();
            $spaceSlider = $this->getAdsSliders();
            $categories = $this->getCategories();
            $cities = $this->getCities($request->user()->country_id);
            if (isset($request->user()->id)) {
                $data = [];
                $notifications = Notifications::where('user_id', $request->user()->id)->get(['id', 'subject', 'message', 'created_at']);
                $notificationsData = Notifications::get(['id', 'subject', 'message', 'created_at']);
                foreach ($notifications as $notification) {
                    array_push($data, $notification);
                }
                foreach ($notificationsData as $notification) {
                    $notDetials = NotificationsDetials::where(['user_id' => $request->user()->id, 'notification_id' => $notification->id])->first();
                    if ($notDetials) {
                        array_push($data, $notification);
                    }
                }
                $countNotification = count($data);
            } else {
                $countNotification = 0;
            }
            $title = Setting::where('key', 'title')->first();
            $desc = Setting::where('key', 'desc')->first();
            $tr = new GoogleTranslate('tr');
            $en = new GoogleTranslate('en');
            if (app()->getLocale() == "en") {
                $home_text = $en->translate($title->value);
                $desc_text = $en->translate($desc->value);
            } elseif (app()->getLocale() == "tr") {
                $home_text = $tr->translate($title->value);
                $desc_text = $tr->translate($desc->value);
            } else {
                $home_text = $title->value;
                $desc_text = $desc->value;
            }

            return $this->returnData('data', ["sliders" => $sliders, "Adspace" => $spaceSlider, "categories" => $categories, "cities" => $cities, "countNotification" => $countNotification, "home_text" => $home_text, "desc_text" => $desc_text], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function myAds(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $current = $this->getAdsUsercurrent($request);
            $previous = $this->getAdsUserprevious($request);
            return $this->returnData('data', ["current" => $current, "previous" => $previous], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function tourGuide(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $ads = $this->tourGuideAds($request);
            return $this->returnData('data', ["ads" => $ads], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function splach(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $splachs = $this->getAdsSplach();
            return $this->returnData('data', ["splachs" => $splachs], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function deleteAds(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'ads_id' => 'required|exists:housings,id',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $ad = $this->houseModel::find($request->ads_id);
            $ad->delete();
            return $this->returnSuccess(200, __('api.deleteSuccess'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function addService(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'category_id' => 'required|exists:categories,id',
                'city_id' => 'nullable|exists:cities,id',
                'street_id' => 'nullable|exists:streets,id',
                'title' => 'nullable|string|min:5',
                'desc' => 'nullable|string|min:5',
                'area' => 'nullable|string|min:1',
                'price' => 'nullable|numeric',
                'lat' => 'nullable|string',
                'long' => 'nullable|string',
                'families' => 'nullable|numeric|in:0,1',
                'individual' => 'nullable|numeric|in:0,1',
                'insurance' => 'nullable|numeric|in:0,1',
                'insurance_value' => 'nullable|numeric',
                'animals' => 'nullable|numeric|in:0,1',
                'council' => 'nullable|numeric|in:0,1',
                'kitchen_table' => 'nullable|numeric|in:0,1',
                'go' => 'nullable|numeric|in:0,1',
                'back' => 'nullable|numeric|in:0,1',
                'visits' => 'nullable|numeric|in:0,1',
                'bed_room' => 'nullable|numeric',
                'smoking' => 'nullable|numeric|in:0,1',
                'Bathrooms' => 'nullable|numeric',
                'camp' => 'nullable|numeric|in:0,1',
                'chalets' => 'nullable|numeric|in:0,1',
                'flight_tickets' => 'nullable|numeric|in:0,1',
                'main_meal' => 'nullable|numeric|in:0,1',
                'housing_included' => 'nullable|numeric|in:0,1',
                'Tour_guide_included' => 'nullable|numeric|in:0,1',
                'breakfast' => 'nullable|numeric|in:0,1',
                'lunch' => 'nullable|numeric|in:0,1',
                'dinner' => 'nullable|numeric|in:0,1',
                'images' => 'nullable|array',
                'accompanying' => 'nullable|array',
                'terms' => 'nullable|array',
                'travel_type_id' => 'nullable|exists:travel_types,id',
                'travel_name' => 'nullable|string',
                'language_id' => 'nullable|string',
                'travel_country_id' => 'nullable|exists:travel_countries,id',
                'group_travel' => 'nullable|numeric',
                'license_number' => 'nullable',
                'indivdual_travel' => 'nullable|numeric',
                'count_days' => 'nullable|numeric',
                'from' => 'nullable|string',
                'to' => 'nullable|string',
                'iban' => 'nullable|string',
                'address' => 'nullable|string',
                'national_image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
                'license_image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
                'guide_image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
                'car_name' => 'nullable|string',
                'event_name' => 'nullable|string',
                'hour_work' => 'nullable|string',
                'moodle' => 'nullable|string',
                'ticket_count' => 'nullable|numeric',
                'hour_price' => 'nullable|numeric',
                'passengers' => 'nullable|numeric',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            if ($request->images) {
                $imageData = [];
                foreach ($request->images as $image) {
                    $imageName = random_int(11111111, 999999999) . '_ads.' . $image->extension();
                    $this->uploadImage($image, $imageName, 'ads');
                    array_push($imageData, $imageName);
                }

            }

            $tr = new GoogleTranslate('tr');
            $en = new GoogleTranslate('en');

            if ($request->national_image) {
                $national_image = random_int(11111111, 999999999) . '_ads.' . $request->national_image->extension();
                $this->uploadImage($request->national_image, $national_image, 'ads');
            } else {
                $national_image = null;
            }
            if ($request->license_image) {
                $license_image = random_int(11111111, 999999999) . '_ads.' . $request->license_image->extension();
                $this->uploadImage($request->license_image, $license_image, 'ads');
            } else {
                $license_image = null;
            }
            if ($request->guide_image) {
                $guide_image = random_int(11111111, 999999999) . '_ads.' . $request->guide_image->extension();
                $this->uploadImage($request->guide_image, $guide_image, 'ads');
            } else {
                $guide_image = null;
            }

            if ($request->car_name) {
                $car_type_en = $en->translate($request->car_name);
                $car_type_tr = $tr->translate($request->car_name);
            } else {
                $car_type_en = null;
                $car_type_tr = null;
            }
            if ($request->event_name) {
                $event_name_en = $en->translate($request->event_name);
                $event_name_tr = $tr->translate($request->event_name);
            } else {
                $event_name_en = null;
                $event_name_tr = null;
            }
            if ($request->travel_name) {
                $travel_name_en = $en->translate($request->travel_name);
                $travel_name_tr = $tr->translate($request->travel_name);
                $travel_name = $request->travel_name;
            } else {
                $travel_name_en = null;
                $travel_name_tr = null;
                $travel_name = null;
            }
            if ($request->title) {
                $name_en = $en->translate($request->title);
                $name_tr = $tr->translate($request->title);
                $name = $request->title;
            } elseif ($request->name) {
                $name_en = $en->translate($request->name);
                $name_tr = $tr->translate($request->name);
                $name = $request->name;
            } else {
                $name_en = null;
                $name_tr = null;
                $name = null;
            }
            ($request->price) ? $price = $request->price : $price = 0;
            ($request->camp) ? $camp = $request->camp : $camp = 0;
            ($request->chalets) ? $chalets = $request->chalets : $chalets = 0;
            ($request->hour_work) ? $hour_work = $request->hour_work : $hour_work = 0;
            ($request->ticket_count) ? $ticket_count = $request->ticket_count : $ticket_count = 0;
            ($request->hour_price) ? $hour_price = $request->hour_price : $hour_price = 0;
            ($request->group_travel) ? $group = $request->group_travel : $group = 0;
            ($request->indivdual_travel) ? $indivdual_travel = $request->group_travel : $indivdual_travel = 0;
            ($request->go) ? $go = $request->go : $go = 0;
            ($request->back) ? $back = $request->back : $back = 0;
            ($request->count_days) ? $count_days = $request->count_days : $count_days = 0;
            $house = $this->houseModel::create([
                'name_ar' => $name,
                'name_en' => $name_en,
                'name_tr' => $name_tr,
                'desc_ar' => $request->desc,
                'desc_en' => $en->translate($request->desc),
                'desc_tr' => $tr->translate($request->desc),
                'area' => $request->area,
                'price' => $price,
                'lat' => $request->lat,
                'long' => $request->long,
                'city_id' => $request->city_id,
                'country_id' => auth()->user()->country_id,
                'street_id' => $request->street_id,
                'user_id' => $request->user()->id,
                'category_id' => $request->category_id,
                'travel_type_id' => $request->travel_type_id,
                'travel_country_id' => $request->travel_country_id,
                'group_travel' => $group,
                'indivdual_travel' => $indivdual_travel,
                'from' => $request->from,
                'to' => $request->to,
                'iban' => $request->iban,
                'address' => $request->adress,
                'national_image' => $national_image,
                'license_image' => $license_image,
                'guide_image' => $guide_image,
                'language_id' => $request->language_id,
                'event_name' => $request->event_name,
                'event_name_en' => $event_name_en,
                'event_name_tr' => $event_name_tr,
                'car_type' => $request->car_name,
                'car_type_en' => $car_type_en,
                'car_type_tr' => $car_type_tr,
                'hour_work' => $hour_work,
                'ticket_count' => $ticket_count,
                'hour_price' => $hour_price,
                'go' => $go,
                'back' => $back,
                'passengers' => $request->passengers,
                'moodle' => $request->moodle,
                'count_days' => $count_days,
                'travel_name' => $travel_name,
                'travel_name_en' => $travel_name_en,
                'travel_name_tr' => $travel_name_tr,
            ]);
            foreach ($imageData as $image) {
                $this->imageModel::create([
                    'image' => $image,
                    'housings_id' => $house->id
                ]);
            }
            if ($request->accompanying) {
                foreach ($request->accompanying as $accompanying) {
                    Accompanying::create([
                        'travel_id' => $accompanying,
                        'house_id' => $house->id
                    ]);
                }
            }
            ($request->insurance) ? $insurance = $request->insurance : $insurance = 0;
            ($request->families) ? $families = $request->families : $families = 0;
            ($request->animals) ? $animals = $request->animals : $animals = 0;
            ($request->visits) ? $visits = $request->visits : $visits = 0;
            ($request->bed_room) ? $bed_room = $request->bed_room : $bed_room = 0;
            ($request->Bathrooms) ? $Bathrooms = $request->Bathrooms : $Bathrooms = 0;
            ($request->council) ? $council = $request->council : $council = 0;
            ($request->individual) ? $individuals = $request->individual : $individuals = 0;
            ($request->smoking) ? $smoking = $request->smoking : $smoking = 0;
            ($request->insurance_value) ? $insurance_value = $request->insurance_value : $insurance_value = 0;
            ($request->kitchen_table) ? $kitchen_table = $request->kitchen_table : $kitchen_table = 0;
            ($request->Tour_guide_included) ? $Tour_guide_included = $request->Tour_guide_included : $Tour_guide_included = 0;
            ($request->housing_included) ? $housing_included = $request->housing_included : $housing_included = 0;
            ($request->main_meal) ? $main_meal = $request->main_meal : $main_meal = 0;
            ($request->flight_tickets) ? $flight_tickets = $request->flight_tickets : $flight_tickets = 0;
            ($request->breakfast) ? $breakfast = $request->breakfast : $breakfast = 0;
            ($request->lunch) ? $lunch = $request->lunch : $lunch = 0;
            ($request->dinner) ? $dinner = $request->dinner : $dinner = 0;
            $this->detialModel::create([
                'insurance' => $insurance,
                'families' => $families,
                'animals' => $animals,
                'visits' => $visits,
                'bed_room' => $bed_room,
                'Bathrooms' => $Bathrooms,
                'council' => $council,
                'individual' => $individuals,
                'smoking' => $smoking,
                'insurance_value' => $insurance_value,
                'kitchen_table' => $kitchen_table,
                'camp' => $camp,
                'chalets' => $chalets,
                'flight_tickets' => $flight_tickets,
                'main_meal' => $main_meal,
                'housing_included' => $housing_included,
                'Tour_guide_included' => $Tour_guide_included,
                'breakfast' => $breakfast,
                'lunch' => $lunch,
                'dinner' => $dinner,
                'housings_id' => $house->id
            ]);
            if ($request->terms) {
                foreach ($request->terms as $term) {
                    $this->termModel::create([
                        'desc_ar' => $term,
                        'desc_en' => $en->translate($term),
                        'desc_tr' => $tr->translate($term),
                        'housings_id' => $house->id
                    ]);
                }
            }

            return $this->returnSuccess(200, __('api.addSuccess'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function getCitiesData(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $cities = $this->getCities($request->user()->country_id);
            return $this->returnData('data', ["cities" => $cities], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getStreetsData(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $streets = $this->getStreets($request->city_id);
            return $this->returnData('data', ["streets" => $streets], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getStreet(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $street = Streets::where('id', $request->street_id)->first(['lat', 'long']);
            return $this->returnData('data', ["street" => $street], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function checkUserDetials(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $user = $this->userDetiaslModel::where('user_id', $request->user()->id)->first();
            if ($user) {
                $userDetiasl = true;
            } else {
                $userDetiasl = false;
            }
            return $this->returnData('data', ["userDetiasl" => $userDetiasl], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function addUserDetials(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'id_number' => 'required',
                'IBAN' => 'required',
                'Residence_permit' => 'required',
                'front_photo' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
                'back_photo' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->front_photo) {
                $front_photo = random_int(11111111, 999999999) . '_UserDetials.' . $request->front_photo->extension();
                $this->uploadImage($request->front_photo, $front_photo, 'UserDetials');
            } else {
                $front_photo = null;
            }
            if ($request->back_photo) {
                $back_photo = random_int(11111111, 999999999) . '_UserDetials.' . $request->back_photo->extension();
                $this->uploadImage($request->back_photo, $back_photo, 'UserDetials');
            } else {
                $back_photo = null;
            }
            $this->userDetiaslModel::create([
                'id_number' => $request->id_number,
                'Residence_permit' => $request->Residence_permit,
                'front_photo' => $front_photo,
                'back_photo' => $back_photo,
                'IBAN' => $request->IBAN,
                'user_id' => $request->user()->id,
            ]);

            return $this->returnSuccess(200, __('api.addUserDetials'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getAds(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);

        if ($request->city_id) {
            $ads = $this->getAdsByCity($request);
        } else {
            $ads = $this->getAdsByCity($request);
        }
        return $this->returnData("data", ["ads" => $ads], __('api.successMessage'));
    }

    public function getAdsByCategory(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'category_id' => 'required|exists:categories,id',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $ads = $this->getCategoryAds($request->category_id, $request->user()->id);

            return $this->returnData("data", ["ads" => $ads], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function getRelatedAds(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $ads = $this->getRelatedAdsTrait($request->category_id, $request->user()->id, $request->ads_id);
            return $this->returnData("data", ["ads" => $ads], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function wheel_of_fortunes(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
            $wheels = $this->wheelModel::where(['status' => 1])->get(['id', 'key', 'value']);
            foreach ($wheels as $wheel) {
                $wheelUser = WheelUsers::where('user_id', $request->user()->id)->whereBetween('created_at', [$start, $end])->first();
                (!$wheelUser) ? $wheel->canTry = true : $wheel->canTry = false;
                if ($wheelUser) {
                    $wheel->timetotryagain = Carbon::parse($wheelUser->created_at)->addHours(24);
                } else {
                    $wheel->timetotryagain = Carbon::now();
                }
            }
            return $this->returnData("data", ["wheels" => $wheels], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function addWheel(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'wheel_id' => 'required|exists:wheel_of_fortunes,id',
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
            $wheelUser = WheelUsers::where('user_id', $request->user()->id)->whereBetween('created_at', [$start, $end])->first();
            if ($wheelUser) {
                return $this->returnError(403, __('api.wrongWheel'));
            }
            WheelUsers::create([
                'user_id' => $request->user()->id,
                'wheel_id' => $request->wheel_id
            ]);
            $wheel = $this->wheelModel::find($request->wheel_id);
            $user = User::find($request->user()->id);
            if ($wheel->key == "points") {
                $user->update([
                    'points' => $user->points + $wheel->value,
                ]);
                return $this->returnSuccess(200, __('api.addPointUser'));
            } else {
                $user->update([
                    'wallet' => $user->wallet + $wheel->value,
                ]);
                Wallet::create([
                    'desc_ar' => 'تم اضافة ' . $wheel->value . ' ريال سعودي الي المحفظة الخاصة بك نتيجة استخدام عجلة الحظ',
                    'desc_en' => ' has been added ' . $wheel->value . ' SAR to your wallet as a result of using the wheel of fortune',
                    'desc_tr' => ' Eklendi ' . $wheel->value . ' Çarkıfelek kullanımının bir sonucu olarak cüzdanınıza SAR',
                    'user_id' => $request->user()->id
                ]);
                return $this->returnSuccess(200, __('api.addWalletUser'));
            }
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getWallet(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $wallets = Wallet::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get(['desc_ar', 'desc_en', 'desc_tr', 'updated_at']);
            foreach ($wallets as $key => $wallet) {
                if (app()->getLocale() == "en") {
                    $data[$key]["desc"] = $wallet->desc_en;
                } elseif (app()->getLocale() == "tr") {
                    $data[$key]["desc"] = $wallet->desc_tr;
                } else {
                    $data[$key]["desc"] = $wallet->desc_ar;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($wallet->updated_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($wallet->updated_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($wallet->updated_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($wallet->updated_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($wallet->updated_at))->locale(app()->getLocale())->year;
            }
            return $this->returnData("data", ["total" => $request->user()->wallet, "wallets" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function addWallet(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'value' => 'required|numeric',
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $user = User::find($request->user()->id);
            $user->update(['wallet' => $user->wallet + $request->value]);

            Wallet::create([
                'desc_ar' => 'تم اضافة ' . $request->value . ' ريال سعودي الي المحفظة الخاصة بك    ',
                'desc_en' => ' has been added ' . $request->value . ' SAR to your wallet',
                'desc_tr' => ' Cüzdanınıza ' . $request->value . ' SAR eklendi',
                'user_id' => $request->user()->id
            ]);
            return $this->returnSuccess(200, __('api.addWalletUser'));

        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function getNotifications(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = [];
            $notifications = Notifications::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get(['id', 'subject', 'message', 'created_at', 'status']);
            $notificationsData = Notifications::get(['id', 'subject', 'message', 'created_at']);
            foreach ($notifications as $notification) {
                $notification->status = (int)$notification->status;
                array_push($data, $notification);
            }
            foreach ($notificationsData as $notification) {
                $notDetials = NotificationsDetials::where(['user_id' => $request->user()->id, 'notification_id' => $notification->id])->first();
                if ($notDetials) {
                    $notification->status = (int)$notDetials->status;
                    array_push($data, $notification);
                }
            }
            return $this->returnData('data', ['notifications' => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function deleteNotification(Request $request)
    {
        try {
            $lang = $this->returnLang($request);
            $this->appModel::setLocale($lang);
            $rules = [
                'notofication_id' => 'required|exists:notifications,id',
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $notification = Notifications::where('id', $request->notofication_id)->first();
            if ($notification->all == 0) {
                $notification->delete();
            } else {
                NotificationsDetials::where(['notification_id' => $request->notofication_id, 'user_id' => $request->user()->id])->delete();
            }

            if ($lang == "ar") {
                return $this->returnSuccess(200, 'تم حذف الاشعار بنجاح');
            } elseif ($lang == "en") {
                return $this->returnSuccess(200, 'The notification was deleted successfully');
            } else {
                return $this->returnSuccess(200, 'Bildirim başarıyla silindi');
            }
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function seeNotification(Request $request)
    {
        try {
            $lang = $this->returnLang($request);
            $this->appModel::setLocale($lang);
            $rules = [
                'notofication_id' => 'required|exists:notifications,id',
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $notification = Notifications::where('id', $request->notofication_id)->first();
            if ($notification->all == 0) {
                $notification->update(['status' => 1]);
            } else {
                NotificationsDetials::where(['notification_id' => $request->notofication_id, 'user_id' => $request->user()->id])->update(['status' => 1]);
            }

            return $this->returnSuccess(200, 'تم بنجاح');
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function getCommenets(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $commenets = $this->commenetModel::where('user_id', $request->user()->id)->get();
            $commentsData = [];
            if ($commenets) {
                foreach ($commenets as $index => $commenet) {
                    if ($commenet->user->image) {
                        $image = env('APP_URL') . "Admin/images/users/" . $commenet->user->image;
                    } else {
                        $image = "https://ui-avatars.com/api/?name=" . $commenet->user->name;
                    }
                    $commentsData[$index]["name"] = $commenet->user->name;
                    $commentsData[$index]["image"] = $image;
                    $commentsData[$index]["commenet"] = $commenet->commenet;
                    $commentsData[$index]["rate"] = $commenet->rate;
                    $commentsData[$index]["created_at"] = $commenet->created_at;
                }
            }
            return $this->returnData('data', ['commenets' => $commentsData], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function filter(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'category_id' => 'required|exists:categories,id',
                'offers' => 'nullable',
                'privace' => 'nullable',
                'min' => 'nullable',
                'max' => 'nullable',
                'street_id' => 'nullable|exists:streets,id',
                'travel_type' => 'nullable|exists:travel_types,id',
                'rate' => 'nullable',
                'word' => 'nullable',
                'camp' => 'nullable',
                'chalets' => 'nullable',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $ads = [];
            if ($request->offers) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    $offer = Offers::where('housings_id', $ad["id"])->first();
                    if ($offer) {
                        $ad["offer"] = $offer->offer;
                        $ad["after_price"] = $ad["price"] - ($ad["price"] * $offer->offer / 100);
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->privace) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    $detials = HouseDetials::where('housings_id', $ad["id"])->first()->private_house;
                    if ($detials) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->max) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    if ($request->max <= $ad["price"]) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->street_id) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    if ($request->street_id == $ad["street_id"]) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->rate) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    $rate = Comments::where('housings_id', $ad["id"])->avg("rate");
                    if ($request->rate == (int)$rate) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->travel_type) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    if ($request->travel_type == $ad["travel_type_id"]) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->chalets) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    if ($ad["chalets"] == 1) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->camp) {
                $data = $this->getCategoryAds($request->category_id, $request->user()->id);
                foreach ($data as $ad) {
                    if ($ad["camp"] == 1) {
                        array_push($ads, $ad);
                    }
                }
            } elseif ($request->word) {
                $ads = $this->getAdsSearch($request->category_id, $request->user()->id, $request->word);
            } else {
                $ads = $this->getCategoryAds($request->category_id, $request->user()->id);
            }


            return $this->returnData("data", ["ads" => $ads], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }


    public function getOrders(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $orders = Order::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get();
            $data = $this->getOrderAds($orders, $request->user()->id);
            $categories = $this->getCategoriesTrait($orders);
            return $this->returnData("data", ["categories" => $categories, "favourites" => $data], __('api.successMessage'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function searchOrders(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            if ($request->date && $request->word) {
                $orders = Order::where('user_id', $request->user()->id)->whereDate('created_at', $request->date)->orderBy('id', 'DESC')->get();
                $data = $this->getOrderAdsSearch($orders, $request->user()->id, $request->word);
            } elseif ($request->date) {
                $orders = Order::where('user_id', $request->user()->id)->whereDate('created_at', $request->date)->orderBy('id', 'DESC')->get();
                $data = $this->getOrderAds($orders, $request->user()->id);
            } elseif ($request->word) {
                $orders = Order::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get();
                $data = $this->getOrderAdsSearch($orders, $request->user()->id, $request->word);
            } else {
                $orders = Order::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get();
                $data = $this->getOrderAds($orders, $request->user()->id);
            }

            $categories = $this->getCategoriesTrait($orders);
            return $this->returnData("data", ["categories" => $categories, "favourites" => $data], __('api.successMessage'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function addCommenet(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'ads_id' => 'required|exists:housings,id',
                'commenet' => 'required|string',
                'rate' => 'required',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $commenet = $this->commenetModel::where(['user_id' => $request->user()->id, 'housings_id' => $request->ads_id])->first();
            if ($commenet) {
                return $this->returnError(403, __('api.notsendCommenet'));
            }
            $this->commenetModel::create([
                'commenet' => $request->commenet,
                'rate' => $request->rate,
                'housings_id' => $request->ads_id,
                'user_id' => $request->user()->id
            ]);

            return $this->returnSuccess(200, __('api.sendCommenet'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function date()
    {
        try {
            $date = Date::where('status', 1)->get();
            return $this->returnData("data", $date, __('api.successMessage'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function comment()
    {
        try {
            $comment = new Comments();
            $comment->user_id = auth()->id();
            $comment->housings_id = request()->ads_id;
            $comment->commenet = request()->commenet;
            $comment->rate = '0';
            $comment->save();
            return $this->returnData("data", $comment, __('api.successMessage'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
