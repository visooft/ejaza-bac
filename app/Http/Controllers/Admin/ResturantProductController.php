<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Additions;
use App\Models\AdditionsDetials;
use App\Models\ColorData;
use App\Models\Menue;
use App\Models\Product;
use App\Models\productAdditionDetials;
use App\Models\productColorDetials;
use App\Models\ProductDetials;
use App\Models\Shop;
use App\Models\Size;
use App\Models\Color;
use App\Models\SubMenue;
use Illuminate\Http\Request;

class ResturantProductController extends Controller
{
    use ImagesTrait;
    private $productModel, $sizeModel, $productDetialsModel, $shopModel, $colorModel, $colorDataModel, $additionsModel, $additionsDetialsModel, $menueModel, $submenueModel, $productColorDetialsModel, $productAdditionDetialsModel;
    public function __construct(Product $product, Size $size, ProductDetials $productDetials, Color $color, ColorData $colorData, Shop $shop, Additions $additions, AdditionsDetials $additionsDetials, Menue $menue, SubMenue $submenue, productColorDetials $productColorDetials, productAdditionDetials $productAdditionDetials)
    {
        $this->productModel = $product;
        $this->sizeModel = $size;
        $this->productDetialsModel = $productDetials;
        $this->shopModel = $shop;
        $this->colorModel = $color;
        $this->colorDataModel = $colorData;
        $this->additionsModel = $additions;
        $this->additionsDetialsModel = $additionsDetials;
        $this->submenueModel = $submenue;
        $this->menueModel = $menue;
        $this->productColorDetialsModel = $productColorDetials;
        $this->productAdditionDetialsModel = $productAdditionDetials;
    }

    public function products($id)
    {
        $products = $this->productModel::where('sub_menue_id', $id)->get();
        $sizes = $this->sizeModel::get();
        foreach ($sizes as $size) {
            if (app()->getLocale() == "ar") {
                $size->name = $size->name_ar;
            } else {
                $size->name = $size->name_en;
            }
        }
        foreach ($products as $product) {
            if (app()->getLocale() == "ar") {
                $product->name = $product->name_ar;
                $product->desc = $product->desc_ar;
            } else {
                $product->name = $product->name_en;
                $product->desc = $product->desc_en;
            }
            $product->image = env('APP_URL') . 'Admin/images/products/' . $product->image;
        }
        return view('Admin.products.products', compact('products', 'sizes', 'id'));
    }
    public function add($id)
    {
        $submenue = $this->submenueModel::find($id);
        $menue = $this->menueModel::find($submenue->menue_id);
        $shop = $this->shopModel::where('user_id', $menue->shop_id)->first();
        if ($shop) {
            $sizes = $this->sizeModel::where('shop_id', $shop->id)->get();
            foreach ($sizes as $size) {
                if (app()->getLocale() == "ar") {
                    $size->name = $size->name_ar;
                } else {
                    $size->name = $size->name_en;
                }
            }
            $data = [];
            $colors = $this->colorModel::where('shop_id', $shop->id)->get();
            foreach ($colors as $color) {
                $colorDetials = $this->colorDataModel::find($color->color_id);
                array_push($data, $colorDetials);
            }
            $additions = $this->additionsModel::where('shop_id', $shop->id)->get();
            foreach ($additions as $add) {
                if (app()->getLocale() == "ar") {
                    $add->name = $add->name_ar;
                } else {
                    $add->name = $add->name_en;
                }
            }
        } else {
            $data = [];
            $additions = [];
            $sizes = [];
        }

        return view('Admin.products.addProduct', compact('sizes', 'id', 'data', 'additions'));
    }
    public function edit($id)
    {
        $product = $this->productModel::where('id', $id)->first();
        $submenue = $this->submenueModel::find($product->sub_menue_id);
        $menue = $this->menueModel::find($submenue->menue_id);
        $shop = $this->shopModel::find($menue->shop_id);;
        if ($shop) {
            $detials = $this->productDetialsModel::where('product_id', $product->id)->get();
            foreach ($detials as $detial) {
                $product->sizeType = $detial->type;
                $size = $this->sizeModel::find($detial->size_id);
                if (app()->getLocale() == "ar") {
                    $detial->name = $size->name_ar;
                } else {
                    $detial->name = $size->name_en;
                }
            }
            $product->detials = $detials;
            $sizes = $this->sizeModel::where('shop_id', $shop->id)->get();
            foreach ($sizes as $size) {
                if (app()->getLocale() == "ar") {
                    $size->name = $size->name_ar;
                } else {
                    $size->name = $size->name_en;
                }
            }
            $data = [];
            $colorDetials = $this->productColorDetialsModel::where('product_id', $product->id)->get();
            foreach ($colorDetials as $detial) {
                $product->colorType = $detial->type;
                $color = $this->colorDataModel::find($detial->color_data_id);
                if ($color) {
                    if (app()->getLocale() == "ar") {
                        $detial->name = $color->name_ar;
                    } else {
                        $detial->name = $color->name_en;
                    }
                }
            }
            $product->colorDetials = $colorDetials;
            $colors = $this->colorModel::where('shop_id', $shop->id)->get();
            foreach ($colors as $color) {
                $colorDetials = $this->colorDataModel::find($color->color_id);
                array_push($data, $colorDetials);
            }
            $additionsDetials = $this->productAdditionDetialsModel::where('product_id', $product->id)->get();
            foreach ($additionsDetials as $detial) {
                $product->additionType = $detial->type;
                $addition = $this->additionsDetialsModel::find($detial->additions_detials_id);
                if (app()->getLocale() == "ar") {
                    $detial->name = $addition->name_ar;
                } else {
                    $detial->name = $addition->name_en;
                }
                $additions = $this->additionsDetialsModel::where('addition_id', $detial->addition_id)->get();
                $detial->additions = $additions;
            }
            $product->additionsDetials = $additionsDetials;
            $additions = $this->additionsModel::where('shop_id', $shop->id)->get();
            foreach ($additions as $add) {
                if (app()->getLocale() == "ar") {
                    $add->name = $add->name_ar;
                } else {
                    $add->name = $add->name_en;
                }
            }
        } else {
            $data = [];
            $additions = [];
            $sizes = [];
        }
        // dd($product);
        return view('Admin.products.editProduct', compact('product', 'sizes', 'id', 'data', 'additions'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'subMenuId' => 'required|exists:sub_menues,id',
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'size' => 'nullable|array',
            'price' => 'nullable|array',
            'priceOne' => 'required|numeric',
            'offer' => 'required|numeric',
            'color' => 'nullable|array',
            'priceColor' => 'nullable|array',
            'additions' => 'nullable|array',
            'additionsDetials' => 'nullable|array',
            'priceadd' => 'nullable|array',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $imageName = time()  . '_product.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'products');

        $this->productModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $imageName,
            'price' => $request->priceOne,
            'sub_menue_id' => $request->subMenuId,
            'offers' => $request->offer,
        ]);
        $product = $this->productModel::orderBy('id', 'DESC')->first();
        if ($request->siveCheck) {
            if ($request->sizeRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            foreach ($request->price as $price) {
                $this->productDetialsModel::create([
                    'price' => $price,
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }
            $detials = $this->productDetialsModel::where('product_id', $product->id)->whereNull('size_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'size_id' => $request->size[$key],
                ]);
            }
        }

        if ($request->colorCheckClick) {
            if ($request->colorRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            foreach ($request->priceColor as $price) {
                $this->productColorDetialsModel::create([
                    'price' => $price,
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }


            $detials = $this->productColorDetialsModel::where('product_id', $product->id)->whereNull('color_data_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'color_data_id' => $request->color[$key],
                ]);
            }
        }
        if ($request->additionCheckClick) {
            if ($request->additionRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            for ($i = 0; $i < count($request->priceadd) - 1; $i++) {
                $this->productAdditionDetialsModel::create([
                    'price' => $request->priceadd[$i],
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }

            $detials = $this->productAdditionDetialsModel::where('product_id', $product->id)->whereNull('addition_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'addition_id' => $request->additions[$key],
                ]);
            }
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'additions_detials_id' => $request->additionsDetials[$key],
                ]);
            }
        }
        if (!$request->colorCheckClick && !$request->additionCheckClick && !$request->siveCheck) {
            $product->update(['price' => $request->priceOne]);
        }

        return redirect()->route('products', $request->subMenuId)->with('done', __('dashboard.addProductSuccess'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'size' => 'nullable|array',
            'price' => 'nullable|array',
            'color' => 'nullable|array',
            'priceColor' => 'nullable|array',
            'additions' => 'nullable|array',
            'additionsDetials' => 'nullable|array',
            'priceadd' => 'nullable|array',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'priceOne' => 'required|numeric',
            'offer' => 'required|numeric',
        ]);

        $product = $this->productModel::find($request->productId);
        if ($request->image) {
            $imageName = time()  . '_product.' . $request->image->extension();
            $oldImagePath = 'Admin/images/products/' . $product->image;

            $this->uploadImage($request->image, $imageName, 'products', $oldImagePath);
        } else {
            $imageName = $product->image;
        }


        $product->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $imageName,
            'price' => $request->priceOne,
            'offers' => $request->offer,
        ]);

        if ($request->siveCheck) {
            $this->productDetialsModel::where('product_id', $product->id)->delete();
            if ($request->sizeRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            foreach ($request->price as $price) {
                $this->productDetialsModel::create([
                    'price' => $price,
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }

            $detials = $this->productDetialsModel::where('product_id', $product->id)->whereNull('size_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'size_id' => $request->size[$key],
                ]);
            }
        }

        if ($request->colorCheckClick) {
            $this->productColorDetialsModel::where('product_id', $product->id)->delete();
            if ($request->colorRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            foreach ($request->priceColor as $price) {
                $this->productColorDetialsModel::create([
                    'price' => $price,
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }


            $detials = $this->productColorDetialsModel::where('product_id', $product->id)->whereNull('color_data_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'color_data_id' => $request->color[$key],
                ]);
            }
        }
        if ($request->additionCheckClick) {
            $this->productAdditionDetialsModel::where('product_id', $product->id)->delete();
            if ($request->additionRequired) {
                $type = 1;
            } else {
                $type = 0;
            }
            for ($i = 0; $i < count($request->priceadd); $i++) {
                $this->productAdditionDetialsModel::create([
                    'price' => $request->priceadd[$i],
                    'product_id' => $product->id,
                    'type' => $type
                ]);
            }

            $detials = $this->productAdditionDetialsModel::where('product_id', $product->id)->whereNull('addition_id')->get();
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'addition_id' => $request->additions[$key],
                ]);
            }
            foreach ($detials as $key => $detial) {
                $detial->update([
                    'additions_detials_id' => $request->additionsDetials[$key],
                ]);
            }
        }
        if (!$request->colorCheckClick && !$request->additionCheckClick && !$request->siveCheck) {
            $product->update(['price' => $request->priceOne]);
        }

        return redirect()->route('products', $product->sub_menue_id)->with('done', __('dashboard.productAddedSuccess'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $product = $this->productModel::find($request->productId);
        if ($product->image) {
            $imageUrl = "Admin/images/products/" . $product->image;
            unlink(public_path($imageUrl));
        }
        $product->forcedelete();

        return back()->with('done', __('dashboard.delteProductMessage'));
    }

    public function hide(Request $request)
    {

        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $product = $this->productModel::find($request->productId);
        $product->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideProductMessage'));
    }
    public function show(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $product = $this->productModel::find($request->productId);
        $product->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showProductMessage'));
    }
    public function addStar($id)
    {
        $product = $this->productModel::find($id);
        $product->update([
            'star' => 1
        ]);
        return back()->with('done', __('dashboard.addStarProductMessage'));
    }
    public function deleteStar($id)
    {
        $product = $this->productModel::find($id);
        $product->update([
            'star' => 0
        ]);
        return back()->with('done', __('dashboard.deleteStarProductMessage'));
    }
}
