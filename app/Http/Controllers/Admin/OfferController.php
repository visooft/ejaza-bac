<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\Housing;
use App\Models\Offers;
use App\Models\SellerRoles;
use App\Models\Shop;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ImagesTrait;

    private $offerModel, $houseModel, $categoryMpodel;
    public function __construct(Offers $offer, Housing $house, Category $category)
    {
        $this->offerModel = $offer;
        $this->houseModel = $house;
        $this->categoryMpodel = $category;
    }

    public function offers()
    {
        $categories = $this->categoryMpodel::where('status', 1)->get(['id', 'name_ar']);
        $offers = $this->offerModel::get();
        return view('Admin.offers', compact('offers', 'categories'));
    }

    public function getProducts(Request $request)
    {
        $ads = $this->houseModel::where(['status' => 1, 'category_id' => $request->category_id])->get();
        return json_encode($ads);
    }
    public function store(Request $request)
    {
        $request->validate([
            'offer' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:housings,id',
        ]);

        $this->offerModel::create([
            'offer' => $request->offer,
            'housings_id' => $request->product_id
        ]);

        return back()->with('done', __('dashboard.addOfferMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'offer' => 'required|numeric',
            'color' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'Ministry_approval' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'offerId' => 'required|exists:offers,id',
        ]);
        $offer = $this->offerModel::find($request->offerId);
        if ($request->has('image')) {
            $imageName = time() . '_offer.' . $request->image->extension();
            $oldImagePath = 'Admin/images/offers/' . $offer->image;

            $this->uploadImage($request->image, $imageName, 'offers', $oldImagePath);
        } else {
            $imageName = $offer->image;
        }
        if ($request->Ministry_approval) {
            $Ministry_approval = random_int(11111, 11111111111) . '_offer.' . $request->Ministry_approval->extension();
            $this->uploadImage($request->Ministry_approval, $Ministry_approval, 'offers');
        } else {
            $Ministry_approval = $offer->Ministry_approval;
        }

        $offer->update([
            'offer' => $request->offer,
            'color' => $request->color,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $imageName,
            'Ministry_approval' => $Ministry_approval,
        ]);
        return back()->with('done', __('dashboard.updateOfferMessage'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'offerId' => 'required|exists:offers,id',
        ]);
        $offer = $this->offerModel::where('id', $request->offerId)->first();
        if ($offer->image) {
            $imageUrl = "Admin/images/offers/" . $offer->image;
            unlink(public_path($imageUrl));
        }
        $offer->delete();
        return back()->with('done', __('dashboard.deleteOfferMessage'));
    }

    public function accepetOffer($id)
    {
        $this->offerModel::where('id', $id)->update(['status' => 1]);
        return redirect()->route('offers')->with('done', __('dashboard.accepetOfferMessage'));
    }

    public function rejecetOffer($id)
    {
        $this->offerModel::where('id', $id)->update(['status' => 2]);
        return redirect()->route('offers')->with('done', __('dashboard.rejecetOfferMessage'));
    }
}
