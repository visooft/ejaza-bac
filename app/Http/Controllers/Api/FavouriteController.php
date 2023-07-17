<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiAdsTraits;
use App\Http\Traits\ApiCategoryTrait;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\getLang;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Favourites;
use App\Models\HouseDetials;
use App\Models\HouseTerms;
use App\Models\Housing;
use App\Models\Images;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FavouriteController extends Controller
{
    use GeneralTrait, getLang, ApiAdsTraits, ApiCategoryTrait;
    private $houseModel, $favouriteModel, $appModel, $categoryModel, $commenetModel, $carbonModel, $imageModel, $termModel, $detialModel;
    public function __construct(Favourites $favourite, Housing $house, App $app, Category $category, Comments $commenet, Carbon $carbon, Images $image, HouseTerms $term, HouseDetials $detials)
    {
        $this->houseModel = $house;
        $this->favouriteModel = $favourite;
        $this->appModel = $app;
        $this->categoryModel = $category;
        $this->carbonModel = $carbon;
        $this->commenetModel = $commenet;
        $this->imageModel = $image;
        $this->termModel = $term;
        $this->detialModel = $detials;
    }

    public function addFavourite(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $favourite = $this->favouriteModel::where(['user_id' => $request->user()->id, 'housings_id' => $request->ads_id])->first();
            if ($favourite) {
                $favourite->delete();
                return $this->returnSuccess(200, __('api.deleteFavourite'));
            }
            $this->favouriteModel::create([
                'housings_id' => $request->ads_id,
                'user_id' => $request->user()->id
            ]);
            return $this->returnSuccess(200, __('api.addFavourite'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getFavouries(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $favourites = $this->favouriteModel::where(['user_id' => $request->user()->id])->get();
            $data = $this->getFavouriteAds($favourites, $request->user()->id);
            $categories = $this->getCategoriesTrait($favourites);
            return $this->returnData("data", ["categories" => $categories, "favourites" => $data], __('api.successMessage'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
}
