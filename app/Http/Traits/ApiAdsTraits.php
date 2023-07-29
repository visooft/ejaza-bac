<?php

namespace App\Http\Traits;

use App\Models\Contact;
use App\Models\Offers;
use App\Models\Rate;
use App\Models\Setting;
use App\Models\Accompanying;
use App\Models\Streets;
use App\Models\travelType;
use App\Models\travelCountry;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

trait ApiAdsTraits
{
    public function getAdsByCity($request)
    {
        $user_id = $request->user()->id;
        $data = [];
        $categories = $this->categoryModel::where('status', 1)->get();
        $key = 0;
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        foreach ($categories as $category) {
            if ($category->id) {
                if ($request->city_id) {
                    if ($request->city_id == "all") {
                        if ($category->id == 6) {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->first();
                        } elseif ($category->id == 8) {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('passengers', '!=', '0')->orderBy('id', 'DESC')->first();
                        } else {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->orderBy('id', 'DESC')->first();
                        }
                    } else {
                        if ($category->id == 6) {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'city_id' => $request->city_id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->first();
                        } elseif ($category->id == 8) {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'city_id' => $request->city_id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('passengers', '!=', '0')->orderBy('id', 'DESC')->first();
                        } else {
                            $ad = $this->houseModel::where(['category_id' => $category->id, 'city_id' => $request->city_id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->orderBy('id', 'DESC')->first();
                        }
                    }
                } else {
                    if ($category->id == 6) {
                        $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->first();
                    } elseif ($category->id == 8) {
                        $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->where('passengers', '!=', '0')->orderBy('id', 'DESC')->first();
                    } else {
                        $ad = $this->houseModel::where(['category_id' => $category->id, 'is_pay' => 0, 'country_id' => $request->user()->country_id, 'show' => 1, 'status' => 1])->orderBy('id', 'DESC')->first();
                    }
                }
                if ($ad) {
                    $category = $this->categoryModel::find($ad->category_id);
                    $type = travelType::find($ad->travel_type_id);
                    $country = travelCountry::find($ad->travel_country_id);
                    if (app()->getLocale() == "en") {
                        ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                        $category->name = $category->name_en;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_en;
                        } elseif ($category->id == 8) {
                            $ad->name = $ad->event_name_en;
                        } else {
                            $ad->name = $ad->name_en;
                        }
                        $ad->desc = $ad->desc_en;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                    } elseif (app()->getLocale() == "tr") {
                        $category->name = $category->name_tr;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_tr;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name_tr;
                        } else {
                            $ad->name = $ad->name_tr;
                        }
                        ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_tr;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                    } else {
                        $category->name = $category->name_ar;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name;
                        } else {
                            $ad->name = $ad->name_ar;
                        }
                        ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                        ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_ar;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                    }
                    $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                    $commentsData = [];
                    if ($commenets) {
                        foreach ($commenets as $index => $commenet) {
                            $commentsData[$index]["name"] = $commenet->user->name;
                            $commentsData[$index]["commenet"] = $commenet->commenet;
                            $commentsData[$index]["rate"] = $commenet->rate;
                            $commentsData[$index]["created_at"] = $commenet->created_at;
                        }
                    }
                    $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $request->user()->id])->first();
                    $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                    foreach ($images as $image) {
                        $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                    }
                    $terms = $this->termModel::where('housings_id', $ad->id)->get();
                    $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                    // dd($adsData[5]->id);
                    $termData = [];
                    foreach ($terms as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $termData[$value]["term"] = $term->desc_en;
                        } elseif (app()->getLocale() == "tr") {
                            $termData[$value]["term"] = $term->desc_tr;
                        } else {
                            $termData[$value]["term"] = $term->desc_ar;
                        }
                    }
                    $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                    $AccompanyingArray = [];
                    $types = travelType::where('type', 'accompanyings')->pluck('id');
                    $typeIds = [];
                    foreach ($Accompanying as $keys => $type) {
                        $AccompanyingArray[$keys] = $type;
                    }
                    $typeData = [];
                    foreach ($types as $camp) {
                        if (in_array($camp, $AccompanyingArray)) {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 1;
                            array_push($typeData, $type);
                        } else {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 0;
                            array_push($typeData, $type);
                        }
                    }
                    $AccompanyingData = [];
                    foreach ($typeData as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                        } elseif (app()->getLocale() == "tr") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                        } else {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                        }
                        $AccompanyingData[$value]["status"] = $term->status;
                    }
                    $data[$key]["id"] = $ad->id;
                    ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                    if ($ad->street_id) {
                        $data[$key]["street_id"] = $ad->street_id;
                        $data[$key]["street_name"] = $ad->street->name_ar;
                    } else {
                        $data[$key]["street_id"] = "";
                        $data[$key]["street_name"] = "";
                    }

                    ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                    $data[$key]["categoryName"] = $category->name;
                    $data[$key]["category_id"] = $category->id;
                    $data[$key]["name"] = $ad->name;
                    $data[$key]["desc"] = $ad->desc;
                    $data[$key]["price"] = $ad->price;
                    $data[$key]["totalPrice"] = $ad->price;
                    if (app()->getLocale() == "tr") {
                        $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                    } elseif (app()->getLocale() == "en") {
                        $data[$key]["currency"] = $en->translate($ad->Country->currency);
                    } else {
                        $data[$key]["currency"] = $ad->Country->currency;
                    }
                    $data[$key]["Accompanying"] = $AccompanyingData;
                    ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                    ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                    $data[$key]["city"] = $ad->cityName;
                    $data[$key]["AdsOwner"] = $ad->user->name;
                    ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                    ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                    ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                    $data[$key]["token"] = $ad->user->token;
                    $data[$key]["commenets"] = $commentsData;
                    $data[$key]["images"] = $images;
                    $data[$key]["terms"] = $termData;
                    $data[$key]["families"] = $detials->families;
                    $data[$key]["insurance"] = $detials->insurance;
                    $data[$key]["private_house"] = $detials->private_house;
                    $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                    $data[$key]["animals"] = $detials->animals;
                    $data[$key]["visits"] = $detials->visits;
                    $data[$key]["group_travel"] = $ad->group_travel;
                    $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                    $data[$key]["bed_room"] = $detials->bed_room;
                    $data[$key]["Bathrooms"] = $detials->Bathrooms;
                    $data[$key]["council"] = $detials->council;
                    $data[$key]["kitchen_table"] = $detials->kitchen_table;
                    $data[$key]["insurance_value"] = $detials->insurance_value;
                    $data[$key]["smoking"] = $detials->smoking;
                    $data[$key]["individual"] = $detials->individual;
                    $data[$key]["flight_tickets"] = $detials->flight_tickets;
                    $data[$key]["main_meal"] = $detials->main_meal;
                    $data[$key]["housing_included"] = $detials->housing_included;
                    $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                    $data[$key]["breakfast"] = $detials->breakfast;
                    $data[$key]["lunch"] = $detials->lunch;
                    $data[$key]["dinner"] = $detials->dinner;
                    $data[$key]["camp"] = $detials->camp;
                    $data[$key]["chalets"] = $detials->chalets;
                    $data[$key]["go"] = $ad->go;
                    $data[$key]["back"] = $ad->back;
                    $data[$key]["count_days"] = $ad->count_days;
                    $data[$key]["travel_name"] = $ad->travel_name;
                    $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                    $rate = Rate::where('housings_id', $ad->id)->get();
                    $total = 0;
                    foreach ($rate as $r) {
                        $total += $r->rate;
                    }
                    if (count($rate) > 0) {
                        $data[$key]["rate"] = $total / count($rate);
                    } else {
                        $data[$key]["rate"] = 0;
                    }
                    $data[$key]["rate_count"] = count($rate);
                    $data[$key]["rate_users"] = $rate;
                    ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                    ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                    ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                    ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                    ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                    ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                    $addition_value = Setting::where('key', 'addition_value')->first()->value;
                    $data[$key]["addition_value"] = $addition_value;
                    if ($favourite) {
                        $data[$key]["favourite"] = true;
                    } else {
                        $data[$key]["favourite"] = false;
                    }
                    if ($ad->user_id == $user_id) {
                        $data[$key]["isMine"] = true;
                    } else {
                        $data[$key]["isMine"] = false;
                    }
                    $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                    if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                        $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                        $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                    } else {
                        $data[$key]["rate"] = "0";
                        $data[$key]["commenetCounts"] = 0;
                    }
                    $offer = Offers::where('housings_id', $ad->id)->first();
                    if ($offer) {
                        $data[$key]["offer"] = $offer->offer;
                        $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                    } else {
                        $data[$key]["offer"] = 0;
                    }
                    $key++;
                }
            }
        }
        return $data;
    }

    public function getAdsUsercurrent($request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        $ads = $this->houseModel::where(['user_id' => $request->user()->id, "status" => 0])->orderBy('id', 'DESC')->get();
        if ($ads) {
            foreach ($ads as $key => $ad) {
                if ($ad) {
                    $category = $this->categoryModel::find($ad->category_id);
                    $type = travelType::find($ad->travel_type_id);
                    $country = travelCountry::find($ad->travel_country_id);
                    if (app()->getLocale() == "en") {
                        ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                        $category->name = $category->name_en;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_en;
                        } elseif ($category->id == 8) {
                            $ad->name = $ad->event_name_en;
                        } else {
                            $ad->name = $ad->name_en;
                        }
                        $ad->desc = $ad->desc_en;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                    } elseif (app()->getLocale() == "tr") {
                        $category->name = $category->name_tr;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_tr;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name_tr;
                        } else {
                            $ad->name = $ad->name_tr;
                        }
                        ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_tr;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                    } else {
                        $category->name = $category->name_ar;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name;
                        } else {
                            $ad->name = $ad->name_ar;
                        }
                        ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                        ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_ar;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                    }
                    $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                    $commentsData = [];
                    if ($commenets) {
                        foreach ($commenets as $index => $commenet) {
                            $commentsData[$index]["name"] = $commenet->user->name;
                            $commentsData[$index]["commenet"] = $commenet->commenet;
                            $commentsData[$index]["rate"] = $commenet->rate;
                            $commentsData[$index]["created_at"] = $commenet->created_at;
                        }
                    }
                    $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $request->user()->id])->first();
                    $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                    foreach ($images as $image) {
                        $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                    }
                    $terms = $this->termModel::where('housings_id', $ad->id)->get();
                    $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                    // dd($adsData[5]->id);
                    $termData = [];
                    foreach ($terms as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $termData[$value]["term"] = $term->desc_en;
                        } elseif (app()->getLocale() == "tr") {
                            $termData[$value]["term"] = $term->desc_tr;
                        } else {
                            $termData[$value]["term"] = $term->desc_ar;
                        }
                    }
                    $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                    $AccompanyingArray = [];
                    $types = travelType::where('type', 'accompanyings')->pluck('id');
                    $typeIds = [];
                    foreach ($Accompanying as $keys => $type) {
                        $AccompanyingArray[$keys] = $type;
                    }
                    $typeData = [];
                    foreach ($types as $camp) {
                        if (in_array($camp, $AccompanyingArray)) {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 1;
                            array_push($typeData, $type);
                        } else {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 0;
                            array_push($typeData, $type);
                        }
                    }
                    $AccompanyingData = [];
                    foreach ($typeData as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                        } elseif (app()->getLocale() == "tr") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                        } else {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                        }
                        $AccompanyingData[$value]["status"] = $term->status;
                    }
                    $data[$key]["id"] = $ad->id;
                    ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                    if ($ad->street_id) {
                        $data[$key]["street_id"] = $ad->street_id;
                        $data[$key]["street_name"] = $ad->street->name_ar;
                    } else {
                        $data[$key]["street_id"] = "";
                        $data[$key]["street_name"] = "";
                    }

                    ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                    $data[$key]["categoryName"] = $category->name;
                    $data[$key]["category_id"] = $category->id;
                    $data[$key]["name"] = $ad->name;
                    $data[$key]["desc"] = $ad->desc;
                    $data[$key]["price"] = $ad->price;
                    $data[$key]["totalPrice"] = $ad->price;
                    if (app()->getLocale() == "tr") {
                        $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                    } elseif (app()->getLocale() == "en") {
                        $data[$key]["currency"] = $en->translate($ad->Country->currency);
                    } else {
                        $data[$key]["currency"] = $ad->Country->currency;
                    }
                    $data[$key]["Accompanying"] = $AccompanyingData;
                    ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                    ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                    $data[$key]["city"] = $ad->cityName;
                    $data[$key]["AdsOwner"] = $ad->user->name;
                    ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                    ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                    ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                    $data[$key]["token"] = $ad->user->token;
                    $data[$key]["commenets"] = $commentsData;
                    $data[$key]["images"] = $images;
                    $data[$key]["terms"] = $termData;
                    $data[$key]["families"] = $detials->families;
                    $data[$key]["insurance"] = $detials->insurance;
                    $data[$key]["private_house"] = $detials->private_house;
                    $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                    $data[$key]["animals"] = $detials->animals;
                    $data[$key]["visits"] = $detials->visits;
                    $data[$key]["group_travel"] = $ad->group_travel;
                    $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                    $data[$key]["bed_room"] = $detials->bed_room;
                    $data[$key]["Bathrooms"] = $detials->Bathrooms;
                    $data[$key]["council"] = $detials->council;
                    $data[$key]["kitchen_table"] = $detials->kitchen_table;
                    $data[$key]["insurance_value"] = $detials->insurance_value;
                    $data[$key]["smoking"] = $detials->smoking;
                    $data[$key]["individual"] = $detials->individual;
                    $data[$key]["flight_tickets"] = $detials->flight_tickets;
                    $data[$key]["main_meal"] = $detials->main_meal;
                    $data[$key]["housing_included"] = $detials->housing_included;
                    $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                    $data[$key]["breakfast"] = $detials->breakfast;
                    $data[$key]["lunch"] = $detials->lunch;
                    $data[$key]["camp"] = $detials->camp;
                    $data[$key]["chalets"] = $detials->chalets;
                    $data[$key]["dinner"] = $detials->dinner;
                    $data[$key]["go"] = $ad->go;
                    $data[$key]["back"] = $ad->back;
                    $data[$key]["count_days"] = $ad->count_days;
                    $data[$key]["travel_name"] = $ad->travel_name;
                    $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                    $rate = Rate::where('housings_id', $ad->id)->get();
                    $total = 0;
                    foreach ($rate as $r) {
                        $total += $r->rate;
                    }
                    if (count($rate) > 0) {
                        $data[$key]["rate"] = $total / count($rate);
                    } else {
                        $data[$key]["rate"] = 0;
                    }
                    ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                    ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                    ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                    ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                    ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                    ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                    $addition_value = Setting::where('key', 'addition_value')->first()->value;
                    $data[$key]["addition_value"] = $addition_value;
                    if ($favourite) {
                        $data[$key]["favourite"] = true;
                    } else {
                        $data[$key]["favourite"] = false;
                    }
                    $data[$key]["isMine"] = true;
                    $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                    if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                        $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                        $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                    } else {
                        $data[$key]["rate"] = "0";
                        $data[$key]["commenetCounts"] = 0;
                    }
                    $offer = Offers::where('housings_id', $ad->id)->first();
                    if ($offer) {
                        $data[$key]["offer"] = $offer->offer;
                        $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                    } else {
                        $data[$key]["offer"] = 0;
                    }
                    $key++;
                }
            }
        }
        return $data;
    }

    public function getAdsUserprevious($request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        $ads = $this->houseModel::where(['user_id' => $request->user()->id])->where('status', '!=', 0)->orderBy('id', 'DESC')->get();
        if ($ads) {
            foreach ($ads as $key => $ad) {
                if ($ad) {
                    $category = $this->categoryModel::find($ad->category_id);
                    $type = travelType::find($ad->travel_type_id);
                    $country = travelCountry::find($ad->travel_country_id);
                    if (app()->getLocale() == "en") {
                        ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                        $category->name = $category->name_en;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_en;
                        } elseif ($category->id == 8) {
                            $ad->name = $ad->event_name_en;
                        } else {
                            $ad->name = $ad->name_en;
                        }
                        $ad->desc = $ad->desc_en;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                    } elseif (app()->getLocale() == "tr") {
                        $category->name = $category->name_tr;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type_tr;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name_tr;
                        } else {
                            $ad->name = $ad->name_tr;
                        }
                        ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                        ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_tr;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                    } else {
                        $category->name = $category->name_ar;
                        if ($category->id == 7) {
                            $ad->name = $ad->car_type;
                        } elseif ($category->id == 6) {
                            $ad->name = $ad->event_name;
                        } else {
                            $ad->name = $ad->name_ar;
                        }
                        ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                        ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                        ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                        $ad->desc = $ad->desc_ar;
                        ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                    }
                    $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                    $commentsData = [];
                    if ($commenets) {
                        foreach ($commenets as $index => $commenet) {
                            $commentsData[$index]["name"] = $commenet->user->name;
                            $commentsData[$index]["commenet"] = $commenet->commenet;
                            $commentsData[$index]["rate"] = $commenet->rate;
                            $commentsData[$index]["created_at"] = $commenet->created_at;
                        }
                    }
                    $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $request->user()->id])->first();
                    $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                    foreach ($images as $image) {
                        $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                    }
                    $terms = $this->termModel::where('housings_id', $ad->id)->get();
                    $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                    // dd($adsData[5]->id);
                    $termData = [];
                    foreach ($terms as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $termData[$value]["term"] = $term->desc_en;
                        } elseif (app()->getLocale() == "tr") {
                            $termData[$value]["term"] = $term->desc_tr;
                        } else {
                            $termData[$value]["term"] = $term->desc_ar;
                        }
                    }
                    $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                    $AccompanyingArray = [];
                    $types = travelType::where('type', 'accompanyings')->pluck('id');
                    $typeIds = [];
                    foreach ($Accompanying as $keys => $type) {
                        $AccompanyingArray[$keys] = $type;
                    }
                    $typeData = [];
                    foreach ($types as $camp) {
                        if (in_array($camp, $AccompanyingArray)) {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 1;
                            array_push($typeData, $type);
                        } else {
                            $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                            $type->status = 0;
                            array_push($typeData, $type);
                        }
                    }
                    $AccompanyingData = [];
                    foreach ($typeData as $value => $term) {
                        if (app()->getLocale() == "en") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                        } elseif (app()->getLocale() == "tr") {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                        } else {
                            $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                        }
                        $AccompanyingData[$value]["status"] = $term->status;
                    }
                    $data[$key]["id"] = $ad->id;
                    ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                    if ($ad->street_id) {
                        $data[$key]["street_id"] = $ad->street_id;
                        $data[$key]["street_name"] = $ad->street->name_ar;
                    } else {
                        $data[$key]["street_id"] = "";
                        $data[$key]["street_name"] = "";
                    }

                    ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                    $data[$key]["categoryName"] = $category->name;
                    $data[$key]["category_id"] = $category->id;
                    $data[$key]["name"] = $ad->name;
                    $data[$key]["desc"] = $ad->desc;
                    $data[$key]["price"] = $ad->price;
                    $data[$key]["totalPrice"] = $ad->price;
                    if (app()->getLocale() == "tr") {
                        $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                    } elseif (app()->getLocale() == "en") {
                        $data[$key]["currency"] = $en->translate($ad->Country->currency);
                    } else {
                        $data[$key]["currency"] = $ad->Country->currency;
                    }
                    $data[$key]["Accompanying"] = $AccompanyingData;
                    ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                    ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                    $data[$key]["city"] = $ad->cityName;
                    $data[$key]["AdsOwner"] = $ad->user->name;
                    ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                    ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                    ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                    $data[$key]["token"] = $ad->user->token;
                    $data[$key]["commenets"] = $commentsData;
                    $data[$key]["images"] = $images;
                    $data[$key]["terms"] = $termData;
                    $data[$key]["families"] = $detials->families;
                    $data[$key]["insurance"] = $detials->insurance;
                    $data[$key]["private_house"] = $detials->private_house;
                    $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                    $data[$key]["animals"] = $detials->animals;
                    $data[$key]["visits"] = $detials->visits;
                    $data[$key]["group_travel"] = $ad->group_travel;
                    $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                    $data[$key]["bed_room"] = $detials->bed_room;
                    $data[$key]["Bathrooms"] = $detials->Bathrooms;
                    $data[$key]["council"] = $detials->council;
                    $data[$key]["kitchen_table"] = $detials->kitchen_table;
                    $data[$key]["insurance_value"] = $detials->insurance_value;
                    $data[$key]["smoking"] = $detials->smoking;
                    $data[$key]["individual"] = $detials->individual;
                    $data[$key]["flight_tickets"] = $detials->flight_tickets;
                    $data[$key]["main_meal"] = $detials->main_meal;
                    $data[$key]["housing_included"] = $detials->housing_included;
                    $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                    $data[$key]["breakfast"] = $detials->breakfast;
                    $data[$key]["lunch"] = $detials->lunch;
                    $data[$key]["dinner"] = $detials->dinner;
                    $data[$key]["camp"] = $detials->camp;
                    $data[$key]["chalets"] = $detials->chalets;
                    $data[$key]["go"] = $ad->go;
                    $data[$key]["back"] = $ad->back;
                    $data[$key]["count_days"] = $ad->count_days;
                    $data[$key]["travel_name"] = $ad->travel_name;
                    $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                    $rate = Rate::where('housings_id', $ad->id)->get();
                    $total = 0;
                    foreach ($rate as $r) {
                        $total += $r->rate;
                    }
                    if (count($rate) > 0) {
                        $data[$key]["rate"] = $total / count($rate);
                    } else {
                        $data[$key]["rate"] = 0;
                    }
                    $data[$key]["is_pay"] = $ad->is_pay;
                    ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                    ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                    ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                    ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                    ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                    ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                    $addition_value = Setting::where('key', 'addition_value')->first()->value;
                    $data[$key]["addition_value"] = $addition_value;
                    if ($favourite) {
                        $data[$key]["favourite"] = true;
                    } else {
                        $data[$key]["favourite"] = false;
                    }
                    $data[$key]["isMine"] = true;
                    $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                    if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                        $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                        $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                    } else {
                        $data[$key]["rate"] = "0";
                        $data[$key]["commenetCounts"] = 0;
                    }
                    $offer = Offers::where('housings_id', $ad->id)->first();
                    if ($offer) {
                        $data[$key]["offer"] = $offer->offer;
                        $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                    } else {
                        $data[$key]["offer"] = 0;
                    }
                    $key++;
                }
            }
        }
        return $data;
    }

    public function getCategoryAds($id, $user_id)
    {
        $category = $this->categoryModel::find($id);
        if ($id == 6) {
            $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->get();
        } elseif ($id == 8) {
            $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('passengers', '!=', '0')->orderBy('id', 'DESC')->get();
        } else {
            $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->orderBy('id', 'DESC')->get();
        }
        $data = $this->getAdsData($category, $ads, $user_id);
        return $data;
    }

    public function getAdsSearch($id, $user_id, $word)
    {
        $category = $this->categoryModel::find($id);
        if (app()->getLocale() == "ar") {
            if ($id == 6) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_ar', 'LIKE', '%' . $word . '%')->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->get();
            } elseif ($id == 8) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_ar', 'LIKE', '%' . $word . '%')->where('passengers', '!=', '0')->orderBy('id', 'DESC')->get();
            } else {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_ar', 'LIKE', '%' . $word . '%')->orderBy('id', 'DESC')->get();
            }
        } elseif (app()->getLocale() == "en") {
            if ($id == 6) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_en', 'LIKE', '%' . $word . '%')->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->get();
            } elseif ($id == 8) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_en', 'LIKE', '%' . $word . '%')->where('passengers', '!=', '0')->orderBy('id', 'DESC')->get();
            } else {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_en', 'LIKE', '%' . $word . '%')->orderBy('id', 'DESC')->get();
            }
        } else {
            if ($id == 6) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_tr', 'LIKE', '%' . $word . '%')->where('ticket_count', '!=', '0')->orderBy('id', 'DESC')->get();
            } elseif ($id == 8) {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_tr', 'LIKE', '%' . $word . '%')->where('passengers', '!=', '0')->orderBy('id', 'DESC')->get();
            } else {
                $ads = $this->houseModel::where(['country_id' => auth()->user()->country_id, 'is_pay' => 0, 'category_id' => $id, 'show' => 1, 'status' => 1])->where('name_tr', 'LIKE', '%' . $word . '%')->orderBy('id', 'DESC')->get();
            }
        }

        $data = $this->getAdsData($category, $ads, $user_id);

        return $data;
    }

    public function getRelatedAdsTrait($id, $user_id, $ads_id)
    {
        $category = $this->categoryModel::find($id);
        $adsData = $this->houseModel::where('id', '<>', $ads_id)->where(['category_id' => $id, 'show' => 1, 'status' => 1])->orderBy('id', 'DESC')->get();
        $data = $this->getAdsData($category, $adsData, $user_id);

        return $data;
    }

    public function getAdsData($category, $adsData, $user_id)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        foreach ($adsData as $key => $ad) {
            if ($ad) {
                $category = $this->categoryModel::find($ad->category_id);
                $type = travelType::find($ad->travel_type_id);
                $country = travelCountry::find($ad->travel_country_id);
                if (app()->getLocale() == "en") {
                    ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                    $category->name = $category->name_en;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_en;
                    } elseif ($category->id == 8) {
                        $ad->name = $ad->event_name_en;
                    } else {
                        $ad->name = $ad->name_en;
                    }
                    $ad->desc = $ad->desc_en;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                } elseif (app()->getLocale() == "tr") {
                    $category->name = $category->name_tr;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_tr;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name_tr;
                    } else {
                        $ad->name = $ad->name_tr;
                    }
                    ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_tr;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                } else {
                    $category->name = $category->name_ar;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name;
                    } else {
                        $ad->name = $ad->name_ar;
                    }
                    ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                    ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_ar;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                }
                $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                $commentsData = [];
                if ($commenets) {
                    foreach ($commenets as $index => $commenet) {
                        $commentsData[$index]["name"] = $commenet->user->name;
                        $commentsData[$index]["commenet"] = $commenet->commenet;
                        $commentsData[$index]["rate"] = $commenet->rate;
                        $commentsData[$index]["created_at"] = $commenet->created_at;
                    }
                }
                $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $user_id])->first();
                $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                foreach ($images as $image) {
                    $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                }
                $terms = $this->termModel::where('housings_id', $ad->id)->get();
                $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                // dd($adsData[5]->id);
                $termData = [];
                foreach ($terms as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $termData[$value]["term"] = $term->desc_en;
                    } elseif (app()->getLocale() == "tr") {
                        $termData[$value]["term"] = $term->desc_tr;
                    } else {
                        $termData[$value]["term"] = $term->desc_ar;
                    }
                }
                $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                $AccompanyingArray = [];
                $types = travelType::where('type', 'accompanyings')->pluck('id');
                $typeIds = [];
                foreach ($Accompanying as $keys => $type) {
                    $AccompanyingArray[$keys] = $type;
                }
                $typeData = [];
                foreach ($types as $camp) {
                    if (in_array($camp, $AccompanyingArray)) {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 1;
                        array_push($typeData, $type);
                    } else {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 0;
                        array_push($typeData, $type);
                    }
                }
                $AccompanyingData = [];
                foreach ($typeData as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                    } elseif (app()->getLocale() == "tr") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                    } else {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                    }
                    $AccompanyingData[$value]["status"] = $term->status;
                }
                $data[$key]["id"] = $ad->id;
                ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                if ($ad->street_id) {
                    $data[$key]["street_id"] = $ad->street_id;
                    $data[$key]["street_name"] = $ad->street->name_ar;
                } else {
                    $data[$key]["street_id"] = "";
                    $data[$key]["street_name"] = "";
                }

                ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                $data[$key]["categoryName"] = $category->name;
                $data[$key]["category_id"] = $category->id;
                $data[$key]["name"] = $ad->name;
                $data[$key]["desc"] = $ad->desc;
                $data[$key]["price"] = $ad->price;
                $data[$key]["totalPrice"] = $ad->price;
                if (app()->getLocale() == "tr") {
                    $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                } elseif (app()->getLocale() == "en") {
                    $data[$key]["currency"] = $en->translate($ad->Country->currency);
                } else {
                    $data[$key]["currency"] = $ad->Country->currency;
                }

                $data[$key]["Accompanying"] = $AccompanyingData;

                ($ad->travel_type_id) ? $data[$key]["travel_type_id"] = $ad->travel_type_id : $data[$key]["travel_type_id"] = "";
                ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                $data[$key]["city"] = $ad->cityName;
                $data[$key]["AdsOwner"] = $ad->user->name;
                ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                $data[$key]["token"] = $ad->user->token;
                $data[$key]["commenets"] = $commentsData;
                $data[$key]["images"] = $images;
                $data[$key]["terms"] = $termData;
                $data[$key]["families"] = $detials->families;
                $data[$key]["insurance"] = $detials->insurance;
                $data[$key]["private_house"] = $detials->private_house;
                $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                $data[$key]["animals"] = $detials->animals;
                $data[$key]["visits"] = $detials->visits;
                $data[$key]["group_travel"] = $ad->group_travel;
                $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                $data[$key]["bed_room"] = $detials->bed_room;
                $data[$key]["Bathrooms"] = $detials->Bathrooms;
                $data[$key]["council"] = $detials->council;
                $data[$key]["kitchen_table"] = $detials->kitchen_table;
                $data[$key]["insurance_value"] = $detials->insurance_value;
                $data[$key]["smoking"] = $detials->smoking;
                $data[$key]["individual"] = $detials->individual;
                $data[$key]["flight_tickets"] = $detials->flight_tickets;
                $data[$key]["main_meal"] = $detials->main_meal;
                $data[$key]["housing_included"] = $detials->housing_included;
                $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                $data[$key]["breakfast"] = $detials->breakfast;
                $data[$key]["lunch"] = $detials->lunch;
                $data[$key]["dinner"] = $detials->dinner;
                $data[$key]["go"] = $ad->go;
                $data[$key]["back"] = $ad->back;
                $data[$key]["count_days"] = $ad->count_days;
                $data[$key]["camp"] = $detials->camp;
                $data[$key]["chalets"] = $detials->chalets;
                $data[$key]["travel_name"] = $ad->travel_name;
                $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                $rate = Rate::where('housings_id', $ad->id)->get();
                $total = 0;
                foreach ($rate as $r) {
                    $total += $r->rate;
                }
                if (count($rate) > 0) {
                    $data[$key]["rate"] = $total / count($rate);
                } else {
                    $data[$key]["rate"] = 0;
                }
                ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                $addition_value = Setting::where('key', 'addition_value')->first()->value;
                $data[$key]["addition_value"] = $addition_value;
                if ($favourite) {
                    $data[$key]["favourite"] = true;
                } else {
                    $data[$key]["favourite"] = false;
                }
                if ($ad->user_id == $user_id) {
                    $data[$key]["isMine"] = true;
                } else {
                    $data[$key]["isMine"] = false;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                    $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                    $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                } else {
                    $data[$key]["rate"] = "0";
                    $data[$key]["commenetCounts"] = 0;
                }
                $offer = Offers::where('housings_id', $ad->id)->first();
                if ($offer) {
                    $data[$key]["offer"] = $offer->offer;
                    $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                } else {
                    $data[$key]["offer"] = 0;
                }
                $key++;
            }
        }
        return $data;
    }

    public function getFavouriteAds($favourites, $user_id)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        $dataCategory = [];
        foreach ($favourites as $key => $favourite) {
            $ad = $this->houseModel::where(['id' => $favourite->housings_id, 'status' => 1, 'show' => 1])->first();
            if ($ad) {
                $category = $this->categoryModel::find($ad->category_id);
                $type = travelType::find($ad->travel_type_id);
                $country = travelCountry::find($ad->travel_country_id);
                if (app()->getLocale() == "en") {
                    ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                    $category->name = $category->name_en;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_en;
                    } elseif ($category->id == 8) {
                        $ad->name = $ad->event_name_en;
                    } else {
                        $ad->name = $ad->name_en;
                    }
                    $ad->desc = $ad->desc_en;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                } elseif (app()->getLocale() == "tr") {
                    $category->name = $category->name_tr;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_tr;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name_tr;
                    } else {
                        $ad->name = $ad->name_tr;
                    }
                    ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_tr;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                } else {
                    $category->name = $category->name_ar;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name;
                    } else {
                        $ad->name = $ad->name_ar;
                    }
                    ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                    ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_ar;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                }
                $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                $commentsData = [];
                if ($commenets) {
                    foreach ($commenets as $index => $commenet) {
                        $commentsData[$index]["name"] = $commenet->user->name;
                        $commentsData[$index]["commenet"] = $commenet->commenet;
                        $commentsData[$index]["rate"] = $commenet->rate;
                        $commentsData[$index]["created_at"] = $commenet->created_at;
                    }
                }
                $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                foreach ($images as $image) {
                    $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                }
                $terms = $this->termModel::where('housings_id', $ad->id)->get();
                $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                // dd($adsData[5]->id);
                $termData = [];
                foreach ($terms as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $termData[$value]["term"] = $term->desc_en;
                    } elseif (app()->getLocale() == "tr") {
                        $termData[$value]["term"] = $term->desc_tr;
                    } else {
                        $termData[$value]["term"] = $term->desc_ar;
                    }
                }
                $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                $AccompanyingArray = [];
                $types = travelType::where('type', 'accompanyings')->pluck('id');
                $typeIds = [];
                foreach ($Accompanying as $keys => $type) {
                    $AccompanyingArray[$keys] = $type;
                }
                $typeData = [];
                foreach ($types as $camp) {
                    if (in_array($camp, $AccompanyingArray)) {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 1;
                        array_push($typeData, $type);
                    } else {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 0;
                        array_push($typeData, $type);
                    }
                }
                $AccompanyingData = [];
                foreach ($typeData as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                    } elseif (app()->getLocale() == "tr") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                    } else {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                    }
                    $AccompanyingData[$value]["status"] = $term->status;
                }
                $data[$key]["id"] = $ad->id;
                ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                if ($ad->street_id) {
                    $data[$key]["street_id"] = $ad->street_id;
                    $data[$key]["street_name"] = $ad->street->name_ar;
                } else {
                    $data[$key]["street_id"] = "";
                    $data[$key]["street_name"] = "";
                }

                ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                $data[$key]["categoryName"] = $category->name;
                $data[$key]["category_id"] = $category->id;
                $data[$key]["name"] = $ad->name;
                $data[$key]["desc"] = $ad->desc;
                $data[$key]["price"] = $ad->price;
                $data[$key]["totalPrice"] = $ad->price;
                if (app()->getLocale() == "tr") {
                    $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                } elseif (app()->getLocale() == "en") {
                    $data[$key]["currency"] = $en->translate($ad->Country->currency);
                } else {
                    $data[$key]["currency"] = $ad->Country->currency;
                }
                $data[$key]["Accompanying"] = $AccompanyingData;
                ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                $data[$key]["city"] = $ad->cityName;
                $data[$key]["AdsOwner"] = $ad->user->name;
                ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                $data[$key]["token"] = $ad->user->token;
                $data[$key]["commenets"] = $commentsData;
                $data[$key]["images"] = $images;
                $data[$key]["terms"] = $termData;
                $data[$key]["families"] = $detials->families;
                $data[$key]["insurance"] = $detials->insurance;
                $data[$key]["private_house"] = $detials->private_house;
                $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                $data[$key]["animals"] = $detials->animals;
                $data[$key]["visits"] = $detials->visits;
                $data[$key]["group_travel"] = $ad->group_travel;
                $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                $data[$key]["bed_room"] = $detials->bed_room;
                $data[$key]["Bathrooms"] = $detials->Bathrooms;
                $data[$key]["council"] = $detials->council;
                $data[$key]["kitchen_table"] = $detials->kitchen_table;
                $data[$key]["insurance_value"] = $detials->insurance_value;
                $data[$key]["smoking"] = $detials->smoking;
                $data[$key]["individual"] = $detials->individual;
                $data[$key]["flight_tickets"] = $detials->flight_tickets;
                $data[$key]["main_meal"] = $detials->main_meal;
                $data[$key]["housing_included"] = $detials->housing_included;
                $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                $data[$key]["camp"] = $detials->camp;
                $data[$key]["chalets"] = $detials->chalets;
                $data[$key]["breakfast"] = $detials->breakfast;
                $data[$key]["lunch"] = $detials->lunch;
                $data[$key]["dinner"] = $detials->dinner;
                $data[$key]["go"] = $ad->go;
                $data[$key]["back"] = $ad->back;
                $data[$key]["count_days"] = $ad->count_days;
                $data[$key]["travel_name"] = $ad->travel_name;
                $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                $rate = Rate::where('housings_id', $ad->id)->get();
                $total = 0;
                foreach ($rate as $r) {
                    $total += $r->rate;
                }
                if (count($rate) > 0) {
                    $data[$key]["rate"] = $total / count($rate);
                } else {
                    $data[$key]["rate"] = 0;
                }
                ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                $addition_value = Setting::where('key', 'addition_value')->first()->value;
                $data[$key]["addition_value"] = $addition_value;
                $data[$key]["favourite"] = true;
                if ($ad->user_id == $user_id) {
                    $data[$key]["isMine"] = true;
                } else {
                    $data[$key]["isMine"] = false;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                    $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                    $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                } else {
                    $data[$key]["rate"] = "0";
                    $data[$key]["commenetCounts"] = 0;
                }
                $offer = Offers::where('housings_id', $ad->id)->first();
                if ($offer) {
                    $data[$key]["offer"] = $offer->offer;
                    $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                } else {
                    $data[$key]["offer"] = 0;
                }
                $key++;
            }
        }
        return $data;
    }

    public function getOrderAds($orders, $user_id)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        $dataCategory = [];
        foreach ($orders as $key => $order) {
            $ad = $this->houseModel::where(['id' => $order->housings_id, 'status' => 1, 'show' => 1])->first();
            if ($ad) {
                $category = $this->categoryModel::find($ad->category_id);
                $type = travelType::find($ad->travel_type_id);
                $country = travelCountry::find($ad->travel_country_id);
                if (app()->getLocale() == "en") {

                    ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                    $category->name = $category->name_en;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_en;
                    } elseif ($category->id == 8) {
                        $ad->name = $ad->event_name_en;
                    } else {
                        $ad->name = $ad->name_en;
                    }
                    $ad->desc = $ad->desc_en;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                } elseif (app()->getLocale() == "tr") {
                    $category->name = $category->name_tr;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_tr;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name_tr;
                    } else {
                        $ad->name = $ad->name_tr;
                    }
                    ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_tr;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                } else {
                    $category->name = $category->name_ar;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name;
                    } else {
                        $ad->name = $ad->name_ar;
                    }
                    ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                    ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_ar;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                }
                $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                $commentsData = [];
                if ($commenets) {
                    foreach ($commenets as $index => $commenet) {
                        $commentsData[$index]["name"] = $commenet->user->name;
                        $commentsData[$index]["commenet"] = $commenet->commenet;
                        $commentsData[$index]["rate"] = $commenet->rate;
                        $commentsData[$index]["created_at"] = $commenet->created_at;
                    }
                }
                $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $user_id])->first();
                $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                foreach ($images as $image) {
                    $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                }
                $terms = $this->termModel::where('housings_id', $ad->id)->get();
                $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                // dd($adsData[5]->id);
                $termData = [];
                foreach ($terms as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $termData[$value]["term"] = $term->desc_en;
                    } elseif (app()->getLocale() == "tr") {
                        $termData[$value]["term"] = $term->desc_tr;
                    } else {
                        $termData[$value]["term"] = $term->desc_ar;
                    }
                }
                $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                $AccompanyingArray = [];
                $types = travelType::where('type', 'accompanyings')->pluck('id');
                $typeIds = [];
                foreach ($Accompanying as $keys => $type) {
                    $AccompanyingArray[$keys] = $type;
                }
                $typeData = [];
                foreach ($types as $camp) {
                    if (in_array($camp, $AccompanyingArray)) {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 1;
                        array_push($typeData, $type);
                    } else {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 0;
                        array_push($typeData, $type);
                    }
                }
                $AccompanyingData = [];
                foreach ($typeData as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                    } elseif (app()->getLocale() == "tr") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                    } else {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                    }
                    $AccompanyingData[$value]["status"] = $term->status;
                }
                $data[$key]["id"] = $ad->id;
                ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                if ($ad->street_id) {
                    $data[$key]["street_id"] = $ad->street_id;
                    $data[$key]["street_name"] = $ad->street->name_ar;
                } else {
                    $data[$key]["street_id"] = "";
                    $data[$key]["street_name"] = "";
                }
                ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                $data[$key]["payment_type"] = __('api.' . $order->payment_type);
                if ($order->payment_type == "cash") {
                    $data[$key]["payment_icon"] = env('APP_URL') . "Admin/images/cash.png";
                } elseif ($order->payment_type == "wallet") {
                    $data[$key]["payment_icon"] = env('APP_URL') . "Admin/images/wallet.png";
                } else {
                    $data[$key]["payment_icon"] = env('APP_URL') . "Admin/images/online.png";
                }
                $data[$key]["categoryName"] = $category->name;
                $data[$key]["category_id"] = $category->id;
                $data[$key]["name"] = $ad->name;
                $data[$key]["desc"] = $ad->desc;
                $data[$key]["price"] = $ad->price;
                $data[$key]["totalPrice"] = $order->total;
                if (app()->getLocale() == "tr") {
                    $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                } elseif (app()->getLocale() == "en") {
                    $data[$key]["currency"] = $en->translate($ad->Country->currency);
                } else {
                    $data[$key]["currency"] = $ad->Country->currency;
                }
                $data[$key]["Accompanying"] = $AccompanyingData;
                ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                $data[$key]["city"] = $ad->cityName;
                $data[$key]["AdsOwner"] = $ad->user->name;
                ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                $data[$key]["token"] = $ad->user->token;
                $data[$key]["commenets"] = $commentsData;
                $data[$key]["images"] = $images;
                $data[$key]["terms"] = $termData;
                $data[$key]["families"] = $detials->families;
                $data[$key]["insurance"] = $detials->insurance;
                $data[$key]["private_house"] = $detials->private_house;
                $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                $data[$key]["animals"] = $detials->animals;
                $data[$key]["visits"] = $detials->visits;
                $data[$key]["group_travel"] = $ad->group_travel;
                $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                $data[$key]["bed_room"] = $detials->bed_room;
                $data[$key]["Bathrooms"] = $detials->Bathrooms;
                $data[$key]["council"] = $detials->council;
                $data[$key]["kitchen_table"] = $detials->kitchen_table;
                $data[$key]["insurance_value"] = $detials->insurance_value;
                $data[$key]["smoking"] = $detials->smoking;
                $data[$key]["individual"] = $detials->individual;
                $data[$key]["flight_tickets"] = $detials->flight_tickets;
                $data[$key]["main_meal"] = $detials->main_meal;
                $data[$key]["housing_included"] = $detials->housing_included;
                $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                $data[$key]["breakfast"] = $detials->breakfast;
                $data[$key]["lunch"] = $detials->lunch;
                $data[$key]["dinner"] = $detials->dinner;
                $data[$key]["camp"] = $detials->camp;
                $data[$key]["chalets"] = $detials->chalets;
                $data[$key]["go"] = $ad->go;
                $data[$key]["back"] = $ad->back;
                $data[$key]["count_days"] = $ad->count_days;
                $data[$key]["travel_name"] = $ad->travel_name;
                $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                $rate = Rate::where('housings_id', $ad->id)->get();
                $total = 0;
                foreach ($rate as $r) {
                    $total += $r->rate;
                }
                if (count($rate) > 0) {
                    $data[$key]["rate"] = $total / count($rate);
                } else {
                    $data[$key]["rate"] = 0;
                }
                ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                $addition_value = Setting::where('key', 'addition_value')->first()->value;
                $data[$key]["addition_value"] = $addition_value;
                if ($favourite) {
                    $data[$key]["favourite"] = true;
                } else {
                    $data[$key]["favourite"] = false;
                }
                if ($ad->user_id == $user_id) {
                    $data[$key]["isMine"] = true;
                } else {
                    $data[$key]["isMine"] = false;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                    $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                    $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                } else {
                    $data[$key]["rate"] = "0";
                    $data[$key]["commenetCounts"] = 0;
                }
                $offer = Offers::where('housings_id', $ad->id)->first();
                if ($offer) {
                    $data[$key]["offer"] = $offer->offer;
                    $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                } else {
                    $data[$key]["offer"] = 0;
                }
                $key++;
            }
        }
        return $data;
    }

    public function getOrderAdsSearch($orders, $user_id, $word)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $data = [];
        $dataCategory = [];
        $key = 0;
        foreach ($orders as $order) {
            if (app()->getLocale() == "ar") {
                $ad = $this->houseModel::where(['id' => $order->housings_id, 'status' => 1, 'show' => 1])->where('name_ar', 'LIKE', '%' . $word . '%')->first();
            } elseif (app()->getLocale() == "en") {
                $ad = $this->houseModel::where(['id' => $order->housings_id, 'status' => 1, 'show' => 1])->where('name_en', 'LIKE', '%' . $word . '%')->first();
            } else {
                $ad = $this->houseModel::where(['id' => $order->housings_id, 'status' => 1, 'show' => 1])->where('name_tr', 'LIKE', '%' . $word . '%')->first();
            }
            if ($ad) {
                $category = $this->categoryModel::find($ad->category_id);
                $type = travelType::find($ad->travel_type_id);
                $country = travelCountry::find($ad->travel_country_id);
                if (app()->getLocale() == "en") {
                    ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_en : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_en : $data[$key]["country"] = "";
                    $category->name = $category->name_en;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_en;
                    } elseif ($category->id == 8) {
                        $ad->name = $ad->event_name_en;
                    } else {
                        $ad->name = $ad->name_en;
                    }
                    $ad->desc = $ad->desc_en;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                } elseif (app()->getLocale() == "tr") {
                    $category->name = $category->name_tr;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type_tr;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name_tr;
                    } else {
                        $ad->name = $ad->name_tr;
                    }
                    ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                    ($type) ? $data[$key]["travel_type"] = $type->name_tr : $data[$key]["travel_type"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_tr : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_tr;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                } else {
                    $category->name = $category->name_ar;
                    if ($category->id == 7) {
                        $ad->name = $ad->car_type;
                    } elseif ($category->id == 6) {
                        $ad->name = $ad->event_name;
                    } else {
                        $ad->name = $ad->name_ar;
                    }
                    ($type) ? $data[$key]["travel_type"] = $type->name_ar : $data[$key]["travel_type"] = "";
                    ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                    ($country) ? $data[$key]["country"] = $country->name_ar : $data[$key]["country"] = "";
                    $ad->desc = $ad->desc_ar;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                }
                $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                $commentsData = [];
                if ($commenets) {
                    foreach ($commenets as $index => $commenet) {
                        $commentsData[$index]["name"] = $commenet->user->name;
                        $commentsData[$index]["commenet"] = $commenet->commenet;
                        $commentsData[$index]["rate"] = $commenet->rate;
                        $commentsData[$index]["created_at"] = $commenet->created_at;
                    }
                }
                $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $user_id])->first();
                $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                foreach ($images as $image) {
                    $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                }
                $terms = $this->termModel::where('housings_id', $ad->id)->get();
                $detials = $this->detialModel::where('housings_id', $ad->id)->first();
                // dd($adsData[5]->id);
                $termData = [];
                foreach ($terms as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $termData[$value]["term"] = $term->desc_en;
                    } elseif (app()->getLocale() == "tr") {
                        $termData[$value]["term"] = $term->desc_tr;
                    } else {
                        $termData[$value]["term"] = $term->desc_ar;
                    }
                }
                $Accompanying = Accompanying::where('house_id', $ad->id)->pluck('travel_id');
                $AccompanyingArray = [];
                $types = travelType::where('type', 'accompanyings')->pluck('id');
                $typeIds = [];
                foreach ($Accompanying as $keys => $type) {
                    $AccompanyingArray[$keys] = $type;
                }
                $typeData = [];
                foreach ($types as $camp) {
                    if (in_array($camp, $AccompanyingArray)) {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 1;
                        array_push($typeData, $type);
                    } else {
                        $type = travelType::where('id', $camp)->first(['name_ar', 'name_en', 'name_tr']);
                        $type->status = 0;
                        array_push($typeData, $type);
                    }
                }
                $AccompanyingData = [];
                foreach ($typeData as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_en : __('api.nofound') . ' ' . $term->name_en;
                    } elseif (app()->getLocale() == "tr") {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_tr : __('api.nofound') . ' ' . $term->name_tr;
                    } else {
                        $AccompanyingData[$value]["name"] = ($term->status == 1) ? __('api.found') . ' ' . $term->name_ar : __('api.nofound') . ' ' . $term->name_ar;
                    }
                    $AccompanyingData[$value]["status"] = $term->status;
                }
                $data[$key]["id"] = $ad->id;
                ($ad->area) ? $data[$key]["area"] = $ad->area : $data[$key]["area"] = "";
                if ($ad->street_id) {
                    $data[$key]["street_id"] = $ad->street_id;
                    $data[$key]["street_name"] = $ad->street->name_ar;
                } else {
                    $data[$key]["street_id"] = "";
                    $data[$key]["street_name"] = "";
                }

                ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                $data[$key]["categoryName"] = $category->name;
                $data[$key]["category_id"] = $category->id;
                $data[$key]["name"] = $ad->name;
                $data[$key]["desc"] = $ad->desc;
                $data[$key]["price"] = $ad->price;
                $data[$key]["totalPrice"] = $order->total;
                if (app()->getLocale() == "tr") {
                    $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                } elseif (app()->getLocale() == "en") {
                    $data[$key]["currency"] = $en->translate($ad->Country->currency);
                } else {
                    $data[$key]["currency"] = $ad->Country->currency;
                }
                $data[$key]["Accompanying"] = $AccompanyingData;
                ($ad->lat) ? $data[$key]["lat"] = $ad->lat : $data[$key]["lat"] = "";
                ($ad->long) ? $data[$key]["long"] = $ad->long : $data[$key]["long"] = "";
                $data[$key]["city"] = $ad->cityName;
                $data[$key]["AdsOwner"] = $ad->user->name;
                ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                $data[$key]["token"] = $ad->user->token;
                $data[$key]["commenets"] = $commentsData;
                $data[$key]["images"] = $images;
                $data[$key]["terms"] = $termData;
                $data[$key]["families"] = $detials->families;
                $data[$key]["insurance"] = $detials->insurance;
                $data[$key]["private_house"] = $detials->private_house;
                $data[$key]["Shared_accommodation"] = $detials->Shared_accommodation;
                $data[$key]["animals"] = $detials->animals;
                $data[$key]["visits"] = $detials->visits;
                $data[$key]["group_travel"] = $ad->group_travel;
                $data[$key]["indivdual_travel"] = $ad->indivdual_travel;
                $data[$key]["bed_room"] = $detials->bed_room;
                $data[$key]["Bathrooms"] = $detials->Bathrooms;
                $data[$key]["council"] = $detials->council;
                $data[$key]["kitchen_table"] = $detials->kitchen_table;
                $data[$key]["insurance_value"] = $detials->insurance_value;
                $data[$key]["smoking"] = $detials->smoking;
                $data[$key]["individual"] = $detials->individual;
                $data[$key]["flight_tickets"] = $detials->flight_tickets;
                $data[$key]["main_meal"] = $detials->main_meal;
                $data[$key]["housing_included"] = $detials->housing_included;
                $data[$key]["Tour_guide_included"] = $detials->Tour_guide_included;
                $data[$key]["breakfast"] = $detials->breakfast;
                $data[$key]["lunch"] = $detials->lunch;
                $data[$key]["dinner"] = $detials->dinner;
                $data[$key]["camp"] = $detials->camp;
                $data[$key]["chalets"] = $detials->chalets;
                $data[$key]["go"] = $ad->go;
                $data[$key]["back"] = $ad->back;
                $data[$key]["count_days"] = $ad->count_days;
                $data[$key]["travel_name"] = $ad->travel_name;
                $data[$key]["ads_user_id"] = User::where('id', $ad->user_id)->first()->name;
                $rate = Rate::where('housings_id', $ad->id)->get();
                $total = 0;
                foreach ($rate as $r) {
                    $total += $r->rate;
                }
                if (count($rate) > 0) {
                    $data[$key]["rate"] = $total / count($rate);
                } else {
                    $data[$key]["rate"] = 0;
                }
                ($ad->passengers) ? $data[$key]["passengers"] = $ad->passengers : $data[$key]["passengers"] = "";
                ($ad->from) ? $data[$key]["from"] = $ad->from : $data[$key]["from"] = "";
                ($ad->to) ? $data[$key]["to"] = $ad->to : $data[$key]["to"] = "";
                ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                ($ad->hour_work) ? $data[$key]["hour_work"] = $ad->hour_work : $data[$key]["hour_work"] = "";
                ($ad->ticket_count) ? $data[$key]["ticket_count"] = $ad->ticket_count : $data[$key]["ticket_count"] = "";
                $addition_value = Setting::where('key', 'addition_value')->first()->value;
                $data[$key]["addition_value"] = $addition_value;
                if ($favourite) {
                    $data[$key]["favourite"] = true;
                } else {
                    $data[$key]["favourite"] = false;
                }
                if ($ad->user_id == $user_id) {
                    $data[$key]["isMine"] = true;
                } else {
                    $data[$key]["isMine"] = false;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                    $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                    $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                } else {
                    $data[$key]["rate"] = "0";
                    $data[$key]["commenetCounts"] = 0;
                }
                $offer = Offers::where('housings_id', $ad->id)->first();
                if ($offer) {
                    $data[$key]["offer"] = $offer->offer;
                    $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                } else {
                    $data[$key]["offer"] = 0;
                }
                $key++;
            }
        }
        return $data;
    }

    public function getCategoriesTrait($favourites)
    {
        $dataCategory = [];
        $data = [];
        $key = 0;
        foreach ($favourites as $favourite) {
            $ads = $this->houseModel::where(['id' => $favourite->housings_id, 'status' => 1, 'show' => 1])->first();
            if ($ads) {
                if (app()->getLocale() == "en") {
                    $ads->categoryName = $ads->category->name_en;
                } elseif (app()->getLocale() == "tr") {
                    $ads->categoryName = $ads->category->name_tr;
                } else {
                    $ads->categoryName = $ads->category->name_ar;
                }
                if (count($dataCategory) > 0) {
                    if (!in_array($ads->category_id, $data)) {
                        $data[$key] = $ads->category_id;
                        $dataCategory[$key]["id"] = $ads->category_id;
                        $dataCategory[$key]["name"] = $ads->categoryName;
                        $dataCategory[$key]["image"] = env('APP_URL') . "Admin/images/category/" . $ads->category->image;
                        $key++;
                    }
                } else {
                    $data[$key] = $ads->category_id;
                    $dataCategory[$key]["id"] = $ads->category_id;
                    $dataCategory[$key]["name"] = $ads->categoryName;
                    $dataCategory[$key]["image"] = env('APP_URL') . "Admin/images/category/" . $ads->category->image;
                    $key++;
                }

            }
        }
        return $dataCategory;
    }

    public function tourGuideAds($request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $key = 0;
        $data = [];
        $ads = $this->houseModel::where(['category_id' => 7, 'status' => 1, 'show' => 1])->get();
        foreach ($ads as $ad) {
            if ($ad) {
                $category = $this->categoryModel::find($ad->category_id);
                if (app()->getLocale() == "en") {
                    ($ad->language_id) ? $data[$key]["language"] = $en->translate($ad->language_id) : $data[$key]["language"] = "";
                    $category->name = $category->name_en;
                    $ad->name = $ad->car_type_en;
                    $ad->desc = $ad->desc_en;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_en : $ad->cityName = "";
                } elseif (app()->getLocale() == "tr") {
                    $category->name = $category->name_tr;
                    $ad->name = $ad->car_type_tr;
                    ($ad->language_id) ? $data[$key]["language"] = $tr->translate($ad->language_id) : $data[$key]["language"] = "";
                    $ad->desc = $ad->desc_tr;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_tr : $ad->cityName = "";
                } else {
                    $category->name = $category->name_ar;
                    $ad->name = $ad->car_type;
                    ($ad->language_id) ? $data[$key]["language"] = $ad->language_id : $data[$key]["language"] = "";
                    $ad->desc = $ad->desc_ar;
                    ($ad->city_id) ? $ad->cityName = $ad->city->name_ar : $ad->cityName = "";
                }
                $commenets = $this->commenetModel::where('housings_id', $ad->id)->get(['commenet', 'rate', 'user_id', 'created_at']);
                $commentsData = [];
                if ($commenets) {
                    foreach ($commenets as $index => $commenet) {
                        $commentsData[$index]["name"] = $commenet->user->name;
                        $commentsData[$index]["commenet"] = $commenet->commenet;
                        $commentsData[$index]["rate"] = $commenet->rate;
                        $commentsData[$index]["created_at"] = $commenet->created_at;
                    }
                }
                $favourite = $this->favouriteModel::where(['housings_id' => $ad->id, 'user_id' => $request->user()->id])->first();
                $images = $this->imageModel::where('housings_id', $ad->id)->get(['image']);
                foreach ($images as $image) {
                    $image->image = env('APP_URL') . 'Admin/images/ads/' . $image->image;
                }
                $terms = $this->termModel::where('housings_id', $ad->id)->get();
                $termData = [];
                foreach ($terms as $value => $term) {
                    if (app()->getLocale() == "en") {
                        $termData[$value]["term"] = $term->desc_en;
                    } elseif (app()->getLocale() == "tr") {
                        $termData[$value]["term"] = $term->desc_tr;
                    } else {
                        $termData[$value]["term"] = $term->desc_ar;
                    }
                }
                $AccompanyingData = [];
                $data[$key]["id"] = $ad->id;
                ($ad->license_number) ? $data[$key]["license_number"] = $ad->license_number : $data[$key]["license_number"] = "";
                $data[$key]["categoryName"] = $category->name;
                $data[$key]["category_id"] = $category->id;
                $data[$key]["name"] = $ad->name;
                $data[$key]["driverName"] = $ad->user->name;
                $data[$key]["desc"] = $ad->desc;
                $data[$key]["price"] = $ad->price;
                $data[$key]["totalPrice"] = $ad->price;
                if (app()->getLocale() == "tr") {
                    $data[$key]["currency"] = $tr->translate($ad->Country->currency);
                } elseif (app()->getLocale() == "en") {
                    $data[$key]["currency"] = $en->translate($ad->Country->currency);
                } else {
                    $data[$key]["currency"] = $ad->Country->currency;
                }
                $data[$key]["moodle"] = $ad->moodle;
                $data[$key]["city"] = $ad->cityName;
                $data[$key]["AdsOwner"] = $ad->user->name;
                ($ad->guide_image) ? $data[$key]["guide_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->guide_image : $data[$key]["guide_image"] = env('APP_URL') . 'Admin/images/users/01.png';
                ($ad->national_image) ? $data[$key]["national_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->national_image : $data[$key]["national_image"] = "";
                ($ad->license_image) ? $data[$key]["license_image"] = env('APP_URL') . 'Admin/images/ads/' . $ad->license_image : $data[$key]["license_image"] = "";
                ($ad->user->image) ? $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/' . $ad->user->image : $data[$key]["sellerImage"] = env('APP_URL') . 'Admin/images/users/01.png';
                $data[$key]["token"] = $ad->user->token;
                $data[$key]["commenets"] = $commentsData;
                $data[$key]["images"] = $images;
                $data[$key]["terms"] = $termData;
                $data[$key]["passengers"] = $ad->passengers;
                ($ad->iban) ? $data[$key]["iban"] = $ad->iban : $data[$key]["iban"] = "";
                ($ad->hour_price) ? $data[$key]["hour_price"] = $ad->hour_price : $data[$key]["hour_price"] = "";
                $addition_value = Setting::where('key', 'addition_value')->first()->value;
                $data[$key]["addition_value"] = $addition_value;
                if ($favourite) {
                    $data[$key]["favourite"] = true;
                } else {
                    $data[$key]["favourite"] = false;
                }
                if ($ad->user_id == $request->user()->id) {
                    $data[$key]["isMine"] = true;
                } else {
                    $data[$key]["isMine"] = false;
                }
                $data[$key]["date"] = $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->isoFormat('HH:MM a') . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->dayName . ', ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->day . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->monthName . ' ' . $this->carbonModel::createFromTimeStamp(strtotime($ad->created_at))->locale(app()->getLocale())->year;
                if ($this->commenetModel::where('housings_id', $ad->id)->avg('rate')) {
                    $data[$key]["rate"] = $this->commenetModel::where('housings_id', $ad->id)->avg('rate');
                    $data[$key]["commenetCounts"] = $this->commenetModel::where('housings_id', $ad->id)->count();
                } else {
                    $data[$key]["rate"] = "0";
                    $data[$key]["commenetCounts"] = 0;
                }
                $offer = Offers::where('housings_id', $ad->id)->first();
                if ($offer) {
                    $data[$key]["offer"] = $offer->offer;
                    $data[$key]["totalPrice"] = $ad->price - ($ad->price * $offer->offer / 100);
                } else {
                    $data[$key]["offer"] = 0;
                }
                $key++;
            }
        }
        return $data;
    }
}
