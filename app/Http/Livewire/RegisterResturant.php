<?php

namespace App\Http\Livewire;

use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\Roles;
use App\Models\Shop;
use App\Models\ShopDetials;
use App\Models\ShopSub;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterResturant extends Component
{

    use ImagesTrait;
    public $name_ar = '';
    public $name_en = '';
    public $desc_ar = '';
    public $desc_en = '';
    public $resturnPhone = '';
    public $address = '';
    public $lat = '';
    public $long = '';
    public $link = '';
    public $delivaryCost = '';
    public $time = '';
    public $subCategories = '';
    public $email = '';
    public $name = '';
    public $emailinput = '';
    public $phone = '';
    public $password = '';
    public $logo = '';
    public $backGround = '';
    public function render()
    {
        $subCategories = SubCategory::where('status', 1)->get();
        foreach ($subCategories as $sub) {
            if (app()->getLocale() == "ar") {
                $sub->name = $sub->name_ar;
            } else {
                $sub->name = $sub->name_en;
            }
        }
        return view('livewire.register-resturant', [
            'subCategories' => $subCategories
        ]);
    }


    public function registerResturant()
    {
        $this->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'name_ar' => 'required|string|min:5|max:200',
            'name_en' => 'required|string|min:5|max:200',
            'desc_en' => 'required|string',
            'desc_ar' => 'required|string',
            'resturnPhone' => 'required|digits:10',
            'phone' => 'nullable|digits:10',
            'address' => 'required|string|min:5|max:200',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'link' => 'nullable|url',
            'delivaryCost' => 'required|numeric',
            'time' => 'required|numeric',
            'emailinput' => 'nullable|email',
            'password' => 'nullable|digits:8',
            'logo' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
            'backGround' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $imageName = time()  . '_shop.' . $this->logo->extension();
        $this->uploadImage($this->logo, $imageName, 'shop');

        $backGround = random_int(0,99999999)  . '_shop.' . $this->backGround->extension();
        $this->uploadImage($this->backGround, $backGround, 'shop');

        $category = Category::where('name_en', 'Resturant')->first();
        if ($this->email) {
            $user = User::where('email', $this->email)->first();
        }
        else {
            $role = Roles::where('name', 'merchant')->first();
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'role_id' => $role->id
            ]);
            $user = User::orderBy('id', 'DESC')->first();
        }

        Shop::create([
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'desc_ar' => $this->desc_ar,
            'desc_en' => $this->desc_en,
            'logo' => $imageName,
            'backGround' => $backGround,
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);
        $resturant = Shop::orderBy('id', 'DESC')->first();

        ShopDetials::create([
            'time' => $this->time,
            'delivaryCost' => $this->delivaryCost,
            'lat' => $this->lat,
            'long' => $this->long,
            'address' => $this->address,
            'link' => $this->link,
            'phone' => $this->resturnPhone,
            'shop_id' => $resturant->id
        ]);
        foreach ($this->subCategories as $category) {
            ShopSub::Create([
                'shop_id' => $resturant->id,
                'sub_category_id' => $category
            ]);
        }
        toastr()->success(__('dashboard.addResturantSuccess'));
        return back();
    }
}
?>
