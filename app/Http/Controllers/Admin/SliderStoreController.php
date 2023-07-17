<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\SliderTrait;
use App\Models\Menue;
use App\Models\Product;
use App\Models\SellerRoles;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\SubMenue;
use Illuminate\Http\Request;

class SliderStoreController extends Controller
{
    use ImagesTrait, SliderTrait;
    private $sliderModel, $productModel, $shopModel, $menueModel, $subMenuModel;
    public function __construct(Slider $slider, Product $product, Shop $shop, Menue $menue, SubMenue $subMenue)
    {
        $this->sliderModel = $slider;
        $this->productModel = $product;
        $this->shopModel = $shop;
        $this->menueModel = $menue;
        $this->subMenuModel = $subMenue;
    }

    public function sliders()
    {
        $allData = [];
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        if (app()->getLocale() == "ar") {
            $shop->name = $shop->name_ar;
        } else {
            $shop->name = $shop->name_en;
        }
        $sliders = $this->sliderModel::orderBy('id', 'DESC')->where('shop_id', $shop->id)->get(['id', 'image', 'shop_id', 'product_id', 'user_id', 'status', 'link', 'desc_ar']);
        foreach ($sliders as $slider) {
            $slider->image = env('APP_URL') . "Admin/images/sliderHome/" . $slider->image;
            if ($slider->product_id) {
                $product = $this->productModel::find($slider->product_id);
                if (app()->getLocale() == "ar") {
                    $slider->productName = $product->name_ar;
                } else {
                    $slider->productName = $product->name_en;
                }
            }
        }
        $menue = $this->menueModel::where('shop_id', $shop->id)->first();
        if ($menue) {
            $subMenues = $this->subMenuModel::where('menue_id', $menue->id)->get();
            foreach ($subMenues as $menue) {
                $products = $this->productModel::where(['sub_menue_id' => $menue->id, 'status' => 1])->get();
                foreach ($products as $product) {
                    if (app()->getLocale() == "ar") {
                        $product->name = $product->name_ar;
                    } else {
                        $product->name = $product->name_en;
                    }
                    array_push($allData, $product);
                }
            }
        }
        return view('Admin.sliderStore', compact('sliders', 'allData', 'shop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productId' => 'nullable|exists:products,id',
            'url' => 'nullable|url',
            'desc_ar' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imageName = time() . '_slider.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'sliderHome');

        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }

        if ($request->productId) {
            $typeAction = "product";
        } elseif ($request->shopId) {
            $typeAction = "store";
        } elseif ($request->url) {
            $typeAction = "link";
        } else {
            $typeAction = "store";
        }
        if ($request->homeScreen) {
            $type = "HomeScreen";
        } else {
            $type = "sliderStore";
        }

        $this->sliderModel::create([
            'type' => $type,
            'shop_id' => $shop->id,
            'user_id' => $shop->user_id,
            'product_id' => $request->productId,
            'typeAction' => $typeAction,
            'image' => $imageName,
            'link' => $request->url,
            'desc_ar' => $request->desc_ar
        ]);

        return back()->with('done', __('dashboard.addSliderMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'shopId' => 'nullable|exists:shops,id',
            'sliderId' => 'required|exists:sliders,id',
            'productId' => 'nullable|exists:products,id',
            'url' => 'nullable|url',
            'desc_ar' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $slider = $this->getSliderById($request->sliderId);

        if ($request->image) {
            $imageName = time() . '_slider.' . $request->image->extension();
            $oldImagePath = 'Admin/images/sliderHome/' . $slider->image;

            $this->uploadImage($request->image, $imageName, 'sliderHome', $oldImagePath);
        } else {
            $imageName = $slider->image;
        }

        if ($request->shopId && $request->productId) {
            $typeAction = "product";
            $url = null;
        } elseif ($request->shopId) {
            $typeAction = "store";
            $url = null;
        } elseif ($request->url) {
            $typeAction = "link";
            $url = $request->url;
        } else {
            $typeAction = "admin";
            $url = null;
        }
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $slider->update([
            'type' => 'HomeScreen',
            'shop_id' => $request->shopId,
            'user_id' => $shop->user_id,
            'product_id' => $request->productId,
            'typeAction' => $typeAction,
            'image' => $imageName,
            'link' => $url,
            'desc_ar' => $request->desc_ar
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
            $imageUrl = "Admin/images/sliderHome/" . $slider->image;
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

    public function getProducts(Request $request)
    {
        $allData = [];
        $request->validate([
            'shopId' => 'required|exists:shops,id',
        ]);
        $menue = $this->menueModel::where('shop_id', $request->shopId)->first();
        $subMenues = $this->subMenuModel::where('menue_id', $menue->id)->get();
        foreach ($subMenues as $menue) {
            $products = $this->productModel::where(['sub_menue_id' => $menue->id, 'status' => 1])->get();
            foreach ($products as $product) {
                if (app()->getLocale() == "ar") {
                    $product->name = $product->name_ar;
                } else {
                    $product->name = $product->name_en;
                }
                array_push($allData, $product);
            }
        }
        $data = json_encode($allData);
        return $data;
    }
}
