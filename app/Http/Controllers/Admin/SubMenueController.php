<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Menue;
use App\Models\Shop;
use App\Models\SubMenue;
use Illuminate\Http\Request;

class SubMenueController extends Controller
{
    use ImagesTrait;
    private $subMenueModel, $menueModel, $shopModel;
    public function __construct(SubMenue $subMenue, Menue $menue, Shop $shop)
    {
        $this->subMenueModel = $subMenue;
        $this->menueModel = $menue;
        $this->shopModel = $shop;
    }
    public function submenues($id)
    {
        $menue = $this->menueModel::where('shop_id', $id)->first();
        $shop = $this->shopModel::find($id);
        if ($shop->category->name_en != "Resturant") {
            $type = 1;
        }
        else {
            $type = 0;
        }
        $id = $menue->id;
        $subMenues = $this->subMenueModel::where('menue_id', $menue->id)->get();
        foreach ($subMenues as $subMenue) {
            if (app()->getLocale() == "ar") {
                $subMenue->name = $subMenue->name_ar;
            }
            else {
                $subMenue->name = $subMenue->name_en;
            }
        }
        return view('Admin.subMenue', compact('subMenues', 'id', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:menues,id',
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        if ($request->image) {
            $imageName = time()  . '_subMenue.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'subMenues');
        }
        else {
            $imageName = null;
        }
        $this->subMenueModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'menue_id' => $request->menueId,
            'image' => $imageName
        ]);
        return back()->with('done', __('dashboard.addSubMenueSuccess'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:sub_menues,id',
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $menue = $this->subMenueModel::find($request->menueId);
        if ($request->image) {
            if ($menue->image) {
                $imageName = time()  . '_subMenue.' . $request->image->extension();
                $oldImagePath = 'Admin/images/subMenues/' . $menue->image;
                $this->uploadImage($request->image, $imageName, 'subMenues', $oldImagePath);
            }
            else {
                $imageName = time()  . '_subMenue.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'subMenues');
            }
        }
        else {
            $imageName = $menue->image;
        }
        $menue->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName
        ]);
        return back()->with('done', __('dashboard.updateSubMenueSuccess'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:sub_menues,id',
        ]);
        $menue = $this->subMenueModel::find($request->menueId);
        if ($menue->image) {
            $imageUrl = "Admin/images/subMenues/" . $menue->image;
            unlink(public_path($imageUrl));
        }
        $menue->delete();

        return back()->with('done', __('dashboard.deleteSubMenueSuccess'));
    }
}
