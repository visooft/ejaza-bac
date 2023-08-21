<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\SliderTrait;
use App\Models\Sliders;
use App\Models\Adspace;
use App\Models\Splach;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImagesTrait, SliderTrait;
    private $sliderModel, $spaceModel, $splachModel;
    public function __construct(Sliders $slider, Adspace $space, Splach $splach)
    {
        $this->sliderModel = $slider;
        $this->spaceModel = $space;
        $this->splachModel = $splach;
    }

    public function sliders()
    {
        $sliders = $this->getSliders();
        return view('Admin.sliders', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time() . '_slider.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'sliders');

        $this->sliderModel::create([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', __('dashboard.addSliderMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'sliderId' => 'required|exists:sliders,id',
        ]);
        $slider = $this->getSliderById($request->sliderId);

        if ($request->image) {
            $imageName = time() . '_slider.' . $request->image->extension();
            $oldImagePath = 'Admin/images/sliders/' . $slider->image;

            $this->uploadImage($request->image, $imageName, 'sliders', $oldImagePath);
        } else {
            $imageName = $slider->image;
        }

        $slider->update([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', __('dashboard.updateSliderMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:sliders,id',
        ]);

        $slider = $this->getSliderById($request->sliderId);
        if ($slider->image) {
            $imageUrl = "Admin/images/sliders/" . $slider->image;
            unlink(public_path($imageUrl));
        }
        $slider->forcedelete();

        return back()->with('done', __('dashboard.deleteSliderMessage'));
    }

    public function hideSlider(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:sliders,id',
        ]);

        $slider = $this->getSliderById($request->sliderId);
        $slider->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideSliderMessage'));
    }
    public function showSlider(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:sliders,id',
        ]);

        $slider = $this->getSliderById($request->sliderId);
        $slider->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showSliderMessage'));
    }

    public function Adspace()
    {
        $sliders = $this->spaceModel::get();
        foreach ($sliders as $slider) {
            $slider->image = env('APP_URL') . "Admin/images/sliders/" . $slider->image;
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
        return view('Admin.AdSpace', compact('sliders'));
    }

    public function storeAdspace(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time() . '_slider.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'sliders');

        $this->spaceModel::create([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', 'تم اضافة المساحة الاعلانية');
    }
    public function updateAdspace(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'sliderId' => 'required|exists:adspaces,id',
        ]);
        $slider = $this->spaceModel::find($request->sliderId);

        if ($request->image) {
            $imageName = time() . '_slider.' . $request->image->extension();
            $oldImagePath = 'Admin/images/sliders/' . $slider->image;

            $this->uploadImage($request->image, $imageName, 'sliders', $oldImagePath);
        } else {
            $imageName = $slider->image;
        }

        $slider->update([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', 'تم تحديث المساحة الاعلانية');
    }
    public function deleteAdspace(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:adspaces,id',
        ]);

        $slider = $this->spaceModel::find($request->sliderId);
        if ($slider->image) {
            $imageUrl = "Admin/images/sliders/" . $slider->image;
            unlink(public_path($imageUrl));
        }
        $slider->forcedelete();

        return back()->with('done', 'تم حذف المساحة الاعلانية');
    }

    public function hideSliderAdspace(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:adspaces,id',
        ]);

        $slider = $this->spaceModel::find($request->sliderId);
        $slider->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء المساحة الاعلانية');
    }
    public function showSliderAdspace(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:adspaces,id',
        ]);

        $slider = $this->spaceModel::find($request->sliderId);
        $slider->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار المساحة الاعلانية');
    }

    public function splach()
    {
        $sliders = $this->splachModel::get();
        foreach ($sliders as $slider) {
            $slider->image = asset("Admin/images/sliders/" . $slider->image);
            if (app()->getLocale() == "tr") {
                $slider->title = $slider->title_tr;
            } elseif (app()->getLocale() == "en") {
                $slider->title = $slider->title_en;
            } else {
                $slider->title = $slider->title_ar;
            }
        }
        return view('Admin.splach', compact('sliders'));
    }

    public function storesplach(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time() . '_slider.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'sliders');

        $this->splachModel::create([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', __('dashboard.addSliderMessage'));
    }
    public function updatesplach(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'title_tr' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'sliderId' => 'required|exists:splaches,id',
        ]);
        $slider = $this->splachModel::find($request->sliderId);

        if ($request->image) {
            $imageName = time() . '_slider.' . $request->image->extension();
            $oldImagePath = 'Admin/images/sliders/' . $slider->image;

            $this->uploadImage($request->image, $imageName, 'sliders', $oldImagePath);
        } else {
            $imageName = $slider->image;
        }

        $slider->update([
            'image' => $imageName,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'title_tr' => $request->title_tr,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'desc_tr' => $request->desc_tr,
        ]);

        return back()->with('done', __('dashboard.updateSliderMessage'));
    }
    public function deletesplach(Request $request)
    {
        $request->validate([
            'sliderId' => 'required|exists:splaches,id',
        ]);

        $slider = $this->splachModel::find($request->sliderId);
        if ($slider->image) {
            $imageUrl = "Admin/images/sliders/" . $slider->image;
            unlink(public_path($imageUrl));
        }
        $slider->forcedelete();

        return back()->with('done', 'تم حذف splach بنجاح');
    }

}
