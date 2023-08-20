<?php

namespace App\Http\Traits;

trait SubCategoryTrait
{

    private function getSubCategoryById($subCategoryId)
    {
        return $this->subCategoryModel::find($subCategoryId);
    }

    private function getSubCategories($id)
    {
        $subCategories = $this->subCategoryModel::where('category_id', $id)->orderBy('id', 'DESC')->get();
        foreach ($subCategories as $sub) {

            $sub->image = asset("Admin/images/subCategory/" . $sub->image);
        }
        return $subCategories;
    }
}
