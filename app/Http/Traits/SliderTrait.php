<?php
namespace App\Http\Traits;

trait SliderTrait
{

    private function getSliderById($sliderId)
    {
        return $this->sliderModel::find($sliderId);
    }
    private function getSliders()
    {
        $sliders = $this->sliderModel::orderBy('id', 'DESC')->get();
        foreach ($sliders as $slider) {
            $slider->image =  asset("Admin/images/sliders/" . $slider->image);
            if (app()->getLocale() == "tr") {
                $slider->title = $slider->title_tr;
                $slider->desc = $slider->desc_tr;
            } elseif (app()->getLocale() == "en") {
                $slider->title = $slider->title_en;
                $slider->desc = $slider->desc_en;
            } else {
                $slider->title = $slider->title_ar;
                $slider->desc = $slider->desc_ar;
            }
        }
        return $sliders;
    }
}
