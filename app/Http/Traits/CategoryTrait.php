<?php
namespace App\Http\Traits;

trait CategoryTrait{

    private function getCategoryById($categoryId)
    {
        return $this->categoryModel::find($categoryId);
    }

    private function getCategories()
    {
        $categories = $this->categoryModel::where('name_en', '!=' ,'Resturant')->orderBy('id', 'DESC')->get();
        foreach ($categories as $category) {
            if (app()->getLocale() == "ar") {
                $category->name = $category->name_ar;
            }
            else {
                $category->name = $category->name_en;
            }
            $category->image = env('APP_URL')."Admin/images/category/".$category->image;
        }
        return $categories;
    }
}
