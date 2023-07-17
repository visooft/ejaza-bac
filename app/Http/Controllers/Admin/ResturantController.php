<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\HouseDetials;
use App\Models\HouseTerms;
use App\Models\Housing;
use App\Models\Images;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;

class ResturantController extends Controller
{
    use ImagesTrait;
    private $userModel, $houseModel, $termsModel, $subCategoryModel, $categoryModel, $detialsModel, $mailModel, $imageModel;
    public function __construct(Housing $house, User $user, SubCategory $subCategory, Category $category, Mail $mail, Images $image, HouseTerms $terms, HouseDetials $detials)
    {
        $this->userModel = $user;
        $this->houseModel = $house;
        $this->subCategoryModel = $subCategory;
        $this->categoryModel = $category;
        $this->mailModel = $mail;
        $this->imageModel = $image;
        $this->detialsModel = $detials;
        $this->termsModel = $terms;
    }

    public function ads($category_id, $status)
    {
        $ads = $this->houseModel::where(['category_id' => $category_id, 'status' => $status])->orderBy('id', 'DESC')->paginate(10);
        foreach ($ads as $ad) {
            if($category_id == 7)
            {
                $ad->name = $ad->car_type_ar;
            }
            elseif($category_id == 8)
            {
                $ad->name = $ad->event_name_ar;
            }
            elseif($category_id == 8)
            {
                $ad->name = $type->name_ar;
            }
            else
            {
                $ad->name = $ad->name_ar;
            }
            // dd($ads[5]->id);
            $ad->image = env('APP_URL') . 'Admin/images/ads/' . $this->imageModel::where('housings_id', $ad->id)->first()->image;
        }
        return view('Admin.resturants.resturants', compact('ads', 'status'));
    }

    public function getDetials($id)
    {
        $images = $this->imageModel::where('housings_id', $id)->get();
        $detisls = $this->detialsModel::where('housings_id', $id)->first();
        $terms = $this->termsModel::where('housings_id', $id)->get();
        $ad = $this->houseModel::find($id);
        return view('Admin.showAds', compact('images', 'detisls', 'terms', 'ad'));
    }

    public function accepetResturant($id)
    {
        $this->houseModel::where('id', $id)->update(['status' => 1, 'show' => 1, 'hide' => 1]);
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
        $this->houseModel::where('id', $id)->update(['status' => 2, 'show' => 0, 'hide' => 1]);
        $user = $this->houseModel::where('id', $id)->first()->user_id;
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
            'resturantId' => 'required|exists:housings,id',
        ]);
        $resturant = $this->houseModel::find($request->resturantId);
        $resturant->forcedelete();

        return back()->with('done', 'تم حذف الاعلان بنجاح');
    }
    public function hideAds(Request $request)
    {
        $request->validate([
            'resturantId' => 'required|exists:housings,id',
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
            'resturantId' => 'required|exists:housings,id',
        ]);
        $resturant = $this->houseModel::find($request->resturantId);
        $resturant->update([
            'hide' => 0,
            'show' => 1
        ]);
        return back()->with('done', 'تم اظهار الاعلان بنجاح');
    }
}
