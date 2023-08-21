<?php

namespace App\Http\Traits;

use Translate;

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
            $category->image = asset("Admin/images/category/" . $category->image);
            $categoryData[$key]['id'] = $category->id;
            $categoryData[$key]['title'] = Translate::trans($category->name);
            $categoryData[$key]['image'] = $category->image;
        }
        return $categoryData;
    }
}
