<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\travelType;
use App\Models\travelCountry;
use App\Models\Housing;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ImagesTrait, CategoryTrait;
    private $categoryModel, $travelModel, $travelCountryModel;
    public function __construct(Category $category, travelType $travel, travelCountry $country)
    {
        $this->categoryModel = $category;
        $this->travelModel = $travel;
        $this->travelCountryModel = $country;
    }
    public function categories()
    {
        $categories = $this->getCategories();
        return view('Admin.categories', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time()  . '_category.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'category');

        $this->categoryModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName,
        ]);

        return back()->with('done', __('dashboard.addCategoryMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $category = $this->getCategoryById($request->categoryId);

        if ($request->image) {
            $imageName = time()  . '_category.' . $request->image->extension();
            $oldImagePath = 'Admin/images/category/' . $category->image;

            $this->uploadImage($request->image, $imageName, 'category', $oldImagePath);
        } else {
            $imageName = $category->image;
        }

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName,
        ]);

        return back()->with('done', __('dashboard.updateCategoryMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
        ]);

        $category = $this->getCategoryById($request->categoryId);
        if ($category->image) {
            $imageUrl = "Admin/images/category/" . $category->image;
            unlink(public_path($imageUrl));
        }
        Housing::where('category_id', $request->categoryId)->delete();
        $category->forcedelete();

        return back()->with('done', __('dashboard.delteCategoryMessage'));
    }

    public function hideCategory(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
        ]);

        $category = $this->getCategoryById($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideCategoryMessage'));
    }
    public function showCategory(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
        ]);

        $category = $this->getCategoryById($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showCategoryMessage'));
    }
    
    public function travel_type()
    {
        $categories = $this->travelModel::where('type', 'travel')->get();
        $status = 0;
        return view('Admin.travel_type', compact('categories', 'status'));
    }
    public function travel_typestore(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);

        $this->travelModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'type' => 'travel'
        ]);

        return back()->with('done', 'تم اضافة النوع بنجاح');
    }
    public function travel_typeupdate(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);
        $category = $this->travelModel::find($request->categoryId);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
        ]);

        return back()->with('done', __('dashboard.updateCategoryMessage'));
    }
    public function travel_typedelete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->forcedelete();

        return back()->with('done', __('dashboard.delteCategoryMessage'));
    }

    public function travel_typehideAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء النوع بنجاح');
    }
    public function travel_typeshowAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار النوع بنجاح');
    }
    
    public function market_type()
    {
        $categories = $this->travelModel::where('type', 'market')->get();
        $status = 2;
        return view('Admin.travel_type', compact('categories', 'status'));
    }
    public function market_typestore(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);

        $this->travelModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'type' => 'market'
        ]);

        return back()->with('done', 'تم اضافة النوع بنجاح');
    }
    public function market_typeupdate(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);
        $category = $this->travelModel::find($request->categoryId);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
        ]);

        return back()->with('done', __('dashboard.updateCategoryMessage'));
    }
    public function market_typedelete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->forcedelete();

        return back()->with('done', __('dashboard.delteCategoryMessage'));
    }

    public function market_typehideAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء النوع بنجاح');
    }
    public function market_typeshowAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار النوع بنجاح');
    }
    
    public function travel_country()
    {
        $categories = $this->travelCountryModel::where('type', 'travel')->get();
        $status = 1;
        return view('Admin.travel_type', compact('categories', 'status'));
    }
    public function travel_countrystore(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time()  . '_country.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'country');

        $this->travelCountryModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'type' => 'travel',
            'image' => $imageName
        ]);

        return back()->with('done', 'تم اضافة  بنجاح');
    }
    public function travel_countryupdate(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_countries,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $category = $this->travelCountryModel::find($request->categoryId);
        
        if($request->image)
        {
            $imageName = time()  . '_country.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'country');
        }
        else
        {
            $imageName = $category->image;
        }
        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName,
        ]);

        return back()->with('done', 'تم التعديل بنجاح');
    }
    public function travel_countrydelete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_countries,id',
        ]);

        $category = $this->travelCountryModel::find($request->categoryId);
        $category->forcedelete();

        return back()->with('done', 'تم الحذف بنجاح');
    }

    public function travel_countryhideAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_countries,id',
        ]);

        $category = $this->travelCountryModel::find($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء  بنجاح');
    }
    public function travel_countryshowAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_countries,id',
        ]);

        $category = $this->travelCountryModel::find($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم  اظهار بنجاح');
    }
    
    public function event_type()
    {
        $categories = $this->travelModel::where('type', 'event')->get();
        $status = 3;
        return view('Admin.travel_type', compact('categories', 'status'));
    }
    public function event_typestore(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);

        $this->travelModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'type' => 'event'
        ]);

        return back()->with('done', 'تم اضافة  بنجاح');
    }
    public function event_typeupdate(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);
        $category = $this->travelModel::find($request->categoryId);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
        ]);

        return back()->with('done', 'تم التعديل بنجاح');
    }
    public function event_typedelete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->forcedelete();

        return back()->with('done', 'تم الحذف بنجاح');
    }

    public function event_typehideAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء  تصنيف القاعلية بنجاح');
    }
    public function event_typeshowAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار تصنيف الفاعلية بنجاح');
    }
    
    public function accompanying()
    {
        $categories = $this->travelModel::where('type', 'accompanyings')->get();
        $status = 4;
        return view('Admin.travel_type', compact('categories', 'status'));
    }
    public function accompanyingstore(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);

        $this->travelModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'type' => 'accompanyings'
        ]);

        return back()->with('done', 'تم اضافة  بنجاح');
    }
    public function accompanyingupdate(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
        ]);
        $category = $this->travelModel::find($request->categoryId);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
        ]);

        return back()->with('done', 'تم التعديل بنجاح');
    }
    public function accompanyingdelete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->forcedelete();

        return back()->with('done', 'تم الحذف بنجاح');
    }

    public function accompanyinghideAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء بنجاح');
    }
    public function accompanyingshowAds(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:travel_types,id',
        ]);

        $category = $this->travelModel::find($request->categoryId);
        $category->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار بنجاح');
    }
}
