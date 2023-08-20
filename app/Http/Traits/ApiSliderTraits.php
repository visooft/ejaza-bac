<?php

namespace App\Http\Traits;

trait ApiSliderTraits
{

    private function getSliderById($sliderId)
    {
        return $this->sliderModel::find($sliderId);
    }
    private function getSliders()
    {
        $sliderData = [];
        $sliders = $this->sliderModel::where('status', 1)->orderBy('id', 'DESC')->get();
        foreach ($sliders as $key => $slider) {
            $slider->image = asset("Admin/images/sliders/" . $slider->image);
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
            $sliderData[$key]['id'] = $slider->id;
            $sliderData[$key]['title'] = $slider->title;
            $sliderData[$key]['desc'] = $slider->desc;
            $sliderData[$key]['image'] = $slider->image;
        }
        return $sliderData;
    }

    private function getAdsSliders()
    {
        $sliderData = [];
        $sliders = $this->spaceModel::where('status', 1)->orderBy('id', 'DESC')->get();
        foreach ($sliders as $key => $slider) {
            $slider->image = asset("Admin/images/sliders/" . $slider->image);
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
            $sliderData[$key]['id'] = $slider->id;
            $sliderData[$key]['title'] = $slider->title;
            $sliderData[$key]['desc'] = $slider->desc;
            $sliderData[$key]['image'] = $slider->image;
        }
        return $sliderData;
    }
    private function getAdsSplach()
    {
        $sliderData = [];
        $sliders = $this->splachModel::orderBy('id', 'DESC')->get();
        foreach ($sliders as $key => $slider) {
            $slider->image = asset("Admin/images/sliders/" . $slider->image);
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
            $sliderData[$key]['id'] = $slider->id;
            $sliderData[$key]['title'] = $slider->title;
            $sliderData[$key]['desc'] = $slider->desc;
            $sliderData[$key]['image'] = $slider->image;
        }
        return $sliderData;
    }
}
