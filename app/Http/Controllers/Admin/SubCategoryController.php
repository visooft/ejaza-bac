<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\SubCategoryTrait;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use SubCategoryTrait, ImagesTrait;
    private $subCategoryModel, $categoryModel;
    public function __construct(SubCategory $subCategory, Category $category)
    {
        $this->subCategoryModel = $subCategory;
        $this->categoryModel = $category;
    }
    public function subcategories($id)
    {
        $subCategories = $this->getSubCategories($id);
        $category = $this->categoryModel::find($id);
        return view('Admin.subCategories', compact('subCategories', 'category'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
            'categoryId' => 'required|exists:categories,id'
        ]);

        $imageName = time()  . '_subCategory.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'subCategory');

        $this->subCategoryModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName,
            'category_id' => $request->categoryId
        ]);

        return back()->with('done', __('dashboard.addSubCategoryMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:sub_categories,id',
            'name_ar' => 'required|string|min:3|max:250',
            'name_en' => 'required|string|min:3|max:250',
            'name_tr' => 'required|string|min:3|max:250',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $sub = $this->getSubCategoryById($request->categoryId);

        if ($request->image) {
            $imageName = time()  . '_subCategory.' . $request->image->extension();
            $oldImagePath = 'Admin/images/subCategory/' . $sub->image;

            $this->uploadImage($request->image, $imageName, 'subCategory', $oldImagePath);
        }
        else {
            $imageName = $sub->image;
        }
        $sub->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'name_tr' => $request->name_tr,
            'image' => $imageName
        ]);

        return back()->with('done', __('dashboard.updateSubCategoryMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:sub_categories,id',
        ]);
        $sub = $this->getSubCategoryById($request->categoryId);
        if ($sub->image) {
            $imageUrl = "Admin/images/subCategory/" . $sub->image;
            unlink(public_path($imageUrl));
        }
        $sub->forcedelete();

        return back()->with('done', __('dashboard.delteSubCategoryMessage'));
    }

    public function hideSubCategory(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:sub_categories,id',
        ]);

        $sub = $this->getSubCategoryById($request->categoryId);
        $sub->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideCategoryMessage'));
    }
    public function showSubCategory(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:sub_categories,id',
        ]);

        $sub = $this->getSubCategoryById($request->categoryId);
        $sub->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showCategoryMessage'));
    }
}
