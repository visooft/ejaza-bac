<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\Travel;
use App\Models\travelCountry;
use App\Models\TravelImages;
use App\Models\TravelTerms;
use App\Models\travelType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GuideController extends Controller
{
    private $userModel, $houseModel, $termsModel, $countryModel, $categoryModel, $typeModel, $mailModel, $imageModel;
    public function __construct(Travel $house, User $user, Category $category, Mail $mail, TravelImages $image, TravelTerms $terms, travelType $type, travelCountry $country)
    {
        $this->userModel = $user;
        $this->houseModel = $house;
        $this->categoryModel = $category;
        $this->mailModel = $mail;
        $this->imageModel = $image;
        $this->typeModel = $type;
        $this->countryModel = $country;
        $this->termsModel = $terms;
    }

    public function gide($status)
    {
        $ads = $this->houseModel::where(['category_id' => 7, 'status' => $status])->orderBy('id', 'DESC')->paginate(10);
        foreach ($ads as $ad) {
            $ad->image = env('APP_URL') . 'Admin/images/ads/' . $this->imageModel::where('travel_id', $ad->id)->first()->image;
        }
        return view('Admin.resturants.guide', compact('ads', 'status'));
    }

    public function getDetials($id)
    {
        $images = $this->imageModel::where('travel_id', $id)->get();
        $terms = $this->termsModel::where('travel_id', $id)->get();
        $ad = $this->houseModel::find($id);
        return view('Admin.showAds', compact('images', 'terms', 'ad'));
    }

    public function accepetResturant($id)
    {
        $this->houseModel::where('id', $id)->update(['status' => 1]);
        $house = $this->houseModel::where('id', $id)->first();
        $title = 'تم الموافقة علي الاعلان';
        // $this->mailModel::send('Admin.emails.accapetAds', ['title' => $title], function ($message) use ($house) {
        //     $message->to($house->user->email);
        //     $message->subject('تم الموافقه علي الاعلان و اصبح الان ظاهر في التطبيق');
        // });
        return back()->with('done', 'تم الموافقة علي الاعلان');
    }

    public function rejecetResturant($id)
    {
        $this->houseModel::where('id', $id)->update(['status' => 2]);
        $user = $this->houseModel::where('id', $id)->first()->user_id;
        $this->userModel::where('id', $user)->update(['status' => 0]);
        $title = 'تم رفض الاعلان';
        // $this->mailModel::send('Admin.emails.accapetAds', ['title' => $title], function ($message) use ($user) {
        //     $message->to($user->email);
        //     $message->subject('تم رفض الاعلان');
        // });
        return back()->with('done', 'تم رفض الاعلان');
    }
    public function delete(Request $request)
    {
        $request->validate([
            'resturantId' => 'required|exists:travel,id',
        ]);
        $resturant = $this->houseModel::find($request->resturantId);
        $resturant->forcedelete();

        return back()->with('done', 'تم حذف الاعلان بنجاح');
    }
    public function hideAds(Request $request)
    {
        $request->validate([
            'resturantId' => 'required|exists:travel,id',
        ]);
        $resturant = $this->houseModel::find($request->resturantId);
        $resturant->update([
            'hide' => 1,
            'show' => 0
        ]);
        return back()->with('done', 'تم اخفاء الاعلان بنجاح');
    }
    public function showAds(Request $request)
    {
        $request->validate([
            'resturantId' => 'required|exists:travel,id',
        ]);
        $resturant = $this->houseModel::find($request->resturantId);
        $resturant->update([
            'hide' => 0,
            'show' => 1
        ]);
        return back()->with('done', 'تم اظهار الاعلان بنجاح');
    }
}
