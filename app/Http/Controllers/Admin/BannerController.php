<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Banner;
use App\Models\BannerCat;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ImagesTrait;
    private $bannerModel, $bannerCatModel, $categoryModel, $subCategoryModel;
    public function __construct(Banner $banner, BannerCat $bannerCat, Category $category, SubCategory $subCategory)
    {
        $this->bannerModel = $banner;
        $this->bannerCatModel = $bannerCat;
        $this->categoryModel = $category;
        $this->subCategoryModel = $subCategory;
    }

    public function banners()
    {
        $banners = $this->bannerModel::get();
        foreach ($banners as $banner) {
            $banner->image = env('APP_URL') . 'Admin/images/banners/' . $banner->image;
            $cats = $this->bannerCatModel::where('banner_id', $banner->id)->get();
            foreach ($cats as $cat) {
                $category = $this->categoryModel::find($cat->cat_id);
                if ($category) {
                    if (app()->getLocale() == "ar") {
                        $cat->name = $category->name_ar;
                    } else {
                        $cat->name = $category->name_en;
                    }
                }
            }
            $banner->cats = $cats;
        }
        $subCategories = $this->categoryModel::where('status', 1)->where('name_en', '!=', 'Resturant')->get();
        foreach ($subCategories as $sub) {
            if (app()->getLocale() == "ar") {
                $sub->name = $sub->name_ar;
            } else {
                $sub->name = $sub->name_en;
            }
        }
        return view('Admin.banners', compact('banners', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:5000',
            'subCategories' => 'required|array',
        ]);
        $imageName = time() . '_banner.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'banners');

        $this->bannerModel::create([
            'image' => $imageName
        ]);

        $banner = $this->bannerModel::orderBy('id', 'DESC')->first();

        foreach ($request->subCategories as $category) {
            $this->bannerCatModel::Create([
                'banner_id' => $banner->id,
                'cat_id' => $category
            ]);
        }

        return back()->with('done', __('dashboard.addBannerSuccess'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'bannerId' => 'required|exists:banners,id',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:5000',
            'subCategories' => 'required|array',
        ]);
        if ($request->image) {
            $banner = $this->bannerModel::find($request->bannerId);
            $imageName = time()  . '_banner.' . $request->image->extension();
            $oldImagePath = 'Admin/images/banners/' . $banner->image;

            $this->uploadImage($request->image, $imageName, 'banners', $oldImagePath);
            $banner->update([
                'image' => $imageName
            ]);
        }
        $banner = $this->bannerModel::find($request->bannerId);
        $this->bannerCatModel::where('banner_id', $banner->id)->delete();
        foreach ($request->subCategories as $category) {
            $this->bannerCatModel::Create([
                'banner_id' => $banner->id,
                'cat_id' => $category
            ]);
        }

        return back()->with('done', __('dashboard.updateBannerSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'bannerId' => 'required|exists:banners,id',
        ]);

        $banner = $this->bannerModel::find($request->bannerId);
        if ($banner->image) {
            $imageUrl = "Admin/images/banners/" . $banner->image;
            unlink(public_path($imageUrl));
        }
        $banner->forcedelete();

        return back()->with('done', __('dashboard.delteBannerMessage'));
    }


    public function hidebanner(Request $request)
    {
        $request->validate([
            'bannerId' => 'required|exists:banners,id',
        ]);

        $banner = $this->bannerModel::find($request->bannerId);
        $banner->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideBannerMessage'));
    }
    public function showbanner(Request $request)
    {
        $request->validate([
            'bannerId' => 'required|exists:banners,id',
        ]);

        $banner = $this->bannerModel::find($request->bannerId);
        $banner->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showBannerMessage'));
    }
}
