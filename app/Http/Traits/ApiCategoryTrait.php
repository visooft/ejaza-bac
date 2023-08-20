<?php

namespace App\Http\Traits;

trait ApiCategoryTrait
{

    private function getCategoryById($categoryId)
    {
        return $this->categoryModel::find($categoryId);
    }

    private function getCategories()
    {
        $categoryData = [];
        $categories = $this->categoryModel::where('status', 1)->get();
        foreach ($categories as $key => $category) {
            if (app()->getLocale() == "tr") {
                $category->name = $category->name_tr;
            } elseif (app()->getLocale() == "en") {
                $category->name = $category->name_en;
            } else {
                $category->name = $category->name_ar;
            }
            $category->image = asset("Admin/images/category/" . $category->image);
            $categoryData[$key]['id'] = $category->id;
            $categoryData[$key]['title'] = $category->name;
            $categoryData[$key]['image'] = $category->image;
        }
        return $categoryData;
    }
}
