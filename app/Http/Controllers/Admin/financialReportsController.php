<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CacherDetials;
use App\Models\Category;
use App\Models\Menue;
use App\Models\Order;
use App\Models\OrderDetials;
use App\Models\Product;
use App\Models\ProductCommenet;
use App\Models\Roles;
use App\Models\SellerRoles;
use App\Models\Shop;
use App\Models\SubMenue;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class financialReportsController extends Controller
{
    private $orderModel, $orderDetialsModel, $roleModel, $userModel, $carbonModel, $bdModel, $shopModel, $categoryModel, $userAddressModel, $cacherDetialsModel, $productModel, $menueModel, $subMenueModel;

    public function __construct(Order $order, OrderDetials $orderDetials, User $user, Roles $role, Carbon $carbon, DB $db, Shop $shop, Category $category, UserAddress $address, CacherDetials $cacherDetials, Product $product, Menue $menue, SubMenue $submenue)
    {
        $this->orderModel = $order;
        $this->orderDetialsModel = $orderDetials;
        $this->userModel = $user;
        $this->userAddressModel = $address;
        $this->roleModel = $role;
        $this->carbonModel = $carbon;
        $this->bdModel = $db;
        $this->shopModel = $shop;
        $this->categoryModel = $category;
        $this->cacherDetialsModel = $cacherDetials;
        $this->productModel = $product;
        $this->menueModel = $menue;
        $this->subMenueModel = $submenue;
    }

    public function countOrders()
    {
        $role = $this->roleModel::where('name', 'User')->first();
        $totalUser = $this->userModel::where('role_id', $role->id)->count();

        $total = $this->orderModel::where(['status' => 1])->sum('total');
        $delivary = $this->orderModel::where(['status' => 1])->sum('delivary');
        $total_sale = $total + $delivary;

        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $sum = 0;
        $numbers_of_orders = $this->bdModel::SELECT("select id, count(*) as count, date(created_at) as date, sum(total) as total, sum(delivary) as delivary from orders WHERE status=1 AND date(created_at) >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY date(created_at) ORDER BY count DESC");
        foreach ($numbers_of_orders as $order) {
            $sum += $order->total;
            $sum += $order->delivary;
        }

        $products = $this->orderDetialsModel::select('product_id', $this->orderDetialsModel::raw('COUNT(product_id) as count'))->groupBy('product_id')->orderBy('count' , 'DESC')->paginate(5);
        foreach ($products as $product) {
            $product->image = env('APP_URL') . 'Admin/images/products/'.$product->product->image;
            $product->view = $product->product->view;
            if (app()->getLocale() == "ar") {
                $product->name = $product->product->name_ar;
            }
            else {
                $product->name = $product->product->name_en;
            }
            $product->rate = (int)ProductCommenet::where('product_id', $product->id)->avg('rate');
        }
        $resturants = [];
        $stores = [];
        $categoryResturant = $this->categoryModel::where('name_en', 'Resturant')->first();
        $bestSellersResturants = $this->orderModel::select('seller_id', 'updated_at', $this->orderModel::raw('COUNT(seller_id) as count'))->groupBy('seller_id')->orderBy('count' , 'DESC')->where(['status' => 1])->get();
        foreach ($bestSellersResturants as $dataStore) {
            $dataStore->from = $this->carbonModel::parse($dataStore->updated_at)->format('g:i a');
            $dataStore->to = $this->carbonModel::parse($dataStore->updated_at)->addHours(2)->format('g:i a');
            $shop = $this->shopModel::where(['user_id' => $dataStore->seller->id, 'status' => 1, 'category_id' => $categoryResturant->id])->first();
            if ($shop) {
                if (count($resturants) < 5) {
                    $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                if (app()->getLocale() == "ar") {
                    $dataStore->name = $shop->name_ar;
                }
                else {
                    $dataStore->name = $shop->name_en;
                }
                $dataStore->shopId = $shop->id;
                array_push($resturants, $dataStore);
                }
            }
            else {
                $shop = $this->shopModel::where(['user_id' => $dataStore->seller->id, 'status' => 1])->where('category_id', '!=', $categoryResturant->id)->first();
                if($shop)
                {
                    if (count($stores) < 5) {
                        $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                        if (app()->getLocale() == "ar") {
                            $dataStore->name = $shop->name_ar;
                        }
                        else {
                            $dataStore->name = $shop->name_en;
                        }
                        $dataStore->shopId = $shop->id;
                        array_push($stores, $dataStore);
                    }
                }
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        $totalorders = $this->orderModel::where(['status' => 1])->count();
        $users = $this->orderModel::select('user_id', 'updated_at', $this->orderModel::raw('COUNT(user_id) as count'))->groupBy('user_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($users as $user) {
            $user->from = $this->carbonModel::parse($user->updated_at)->format('g:i a');
            $user->to = $this->carbonModel::parse($user->updated_at)->addHours(2)->format('g:i a');
            if ($user->user->image) {
                $user->image = env('APP_URL').'Admin/images/users/'.$user->user->image;
            }
            else {
                $user->image = env('APP_URL').'Admin/images/users/user.png';
            }
        }
        return view('Admin.reports.counorders', compact('total_sale', 'total_saleToday', 'totalUser', 'sum', 'numbers_of_orders', 'products', 'stores', 'resturants', 'regions', 'totalorders', 'users'));
    }

    public function countOrdersClient()
    {
        $role = $this->roleModel::where('name', 'User')->first();
        $totalUser = $this->userModel::where('role_id', $role->id)->count();
        $totalorders = $this->orderModel::where(['status' => 1])->count();
        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $users = $this->orderModel::select('user_id', 'updated_at', $this->orderModel::raw('COUNT(user_id) as count'))->groupBy('user_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($users as $user) {
            $user->from = $this->carbonModel::parse($user->updated_at)->format('g:i a');
            $user->to = $this->carbonModel::parse($user->updated_at)->addHours(2)->format('g:i a');
            if ($user->user->image) {
                $user->image = env('APP_URL').'Admin/images/users/'.$user->user->image;
            }
            else {
                $user->image = "https://ui-avatars.com/api/?name=" . $user->user->name;
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        return view('Admin.reports.countOrdersClient', compact('totalUser', 'totalorders', 'total_saleToday', 'users', 'regions'));
    }

    public function countOrdersResturant()
    {
        $resturants = [];
        $categoryResturant = $this->categoryModel::where('name_en', 'Resturant')->first();
        $shopsCount = $this->shopModel::where(['status' => 1, 'category_id' => $categoryResturant->id])->count();
        $bestSellersResturants = $this->orderModel::select('seller_id', 'updated_at', $this->orderModel::raw('COUNT(seller_id) as count'))->groupBy('seller_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($bestSellersResturants as $dataStore) {
            $dataStore->from = $this->carbonModel::parse($dataStore->updated_at)->format('g:i a');
            $dataStore->to = $this->carbonModel::parse($dataStore->updated_at)->addHours(2)->format('g:i a');
            $shop = $this->shopModel::where(['user_id' => $dataStore->seller_id, 'status' => 1, 'category_id' => $categoryResturant->id])->first();
            if ($shop) {
                if (count($resturants) < 5) {
                    $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                if (app()->getLocale() == "ar") {
                    $dataStore->name = $shop->name_ar;
                }
                else {
                    $dataStore->name = $shop->name_en;
                }
                $dataStore->shopId = $shop->id;
                array_push($resturants, $dataStore);
                }
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        return view('Admin.reports.countOrdersResturant', compact('shopsCount', 'resturants', 'regions'));
    }

    public function resturantProducts($id)
    {
        $data = [];
        $menue = $this->menueModel::where('shop_id', $id)->first();
        $submenues = $this->subMenueModel::where('menue_id', $menue->id)->get();
        foreach ($submenues as $sub) {
            $products = $this->productModel::where('sub_menue_id', $sub->id)->get();
            foreach ($products as $product) {
                if (app()->getLocale() == "ar") {
                    $product->name = $product->name_ar;
                }
                else {
                    $product->name = $product->name_en;
                }
                $product->image = env('APP_URL').'Admin/images/products/'.$product->image;
                $product->count = $this->orderDetialsModel::where('product_id', $product->id)->count();
                array_push($data, $product);
            }
        }
        return view('Admin.reports.products', compact('data'));
    }

    public function countOrdersStore()
    {
        $resturants = [];
        $categoryResturant = $this->categoryModel::where('name_en', 'Resturant')->first();
        $shopsCount = $this->shopModel::where(['status' => 1])->where('category_id', '!=', $categoryResturant->id)->count();
        $bestSellersResturants = $this->orderModel::select('seller_id', 'updated_at', $this->orderModel::raw('COUNT(seller_id) as count'))->groupBy('seller_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($bestSellersResturants as $dataStore) {
            $dataStore->from = $this->carbonModel::parse($dataStore->updated_at)->format('g:i a');
            $dataStore->to = $this->carbonModel::parse($dataStore->updated_at)->addHours(2)->format('g:i a');
            $shop = $this->shopModel::where(['user_id' => $dataStore->seller_id, 'status' => 1])->where('category_id', '!=', $categoryResturant->id)->first();
            if ($shop) {
                if (count($resturants) < 5) {
                    $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                if (app()->getLocale() == "ar") {
                    $dataStore->name = $shop->name_ar;
                }
                else {
                    $dataStore->name = $shop->name_en;
                }
                array_push($resturants, $dataStore);
                }
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        return view('Admin.reports.countOrdersStore', compact('shopsCount', 'resturants', 'regions'));
    }
    public function countOrdersDelivary()
    {
        $role = $this->roleModel::where('name', 'Delivary')->first();
        $totalUser = $this->userModel::where('role_id', $role->id)->count();
        $totalorders = $this->orderModel::where(['status' => 1])->count();
        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $usersData = [];
        $users = $this->orderModel::select('delivary_id', $this->orderModel::raw('COUNT(delivary_id) as count'))->groupBy('delivary_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($users as $delivary) {
            $user = $this->userModel::find($delivary->delivary_id);
            if ($user) {
                $delivary->name = $user->name;
                $delivary->id = $user->id;
                $delivary->email = $user->email;
                $delivary->phone = $user->phone;
                if ($user->image) {
                    $delivary->image = env('APP_URL').'Admin/images/deliveries/'.$user->image;
                }
                else {
                    $delivary->image = env('APP_URL').'Admin/images/users/user.png';
                }
                array_push($usersData, $delivary);
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        return view('Admin.reports.countOrdersDelivary', compact('totalUser', 'totalorders', 'total_saleToday', 'usersData', 'regions'));
    }
    public function countOrdersCacher()
    {
        $role = $this->roleModel::where('name', 'Casher')->first();
        $totalUser = $this->userModel::where('role_id', $role->id)->count();
        $totalorders = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done'])->count();
        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done'])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done'])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $usersData = [];
        $users = $this->orderModel::select('cacher_id', $this->orderModel::raw('COUNT(cacher_id) as count'))->groupBy('cacher_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'orderStatus' => 'done'])->paginate(5);
        foreach ($users as $cacher) {
            $user = $this->userModel::find($cacher->cacher_id);
            if ($user) {
                $cacher->name = $user->name;
                $cacher->id = $user->id;
                $cacher->email = $user->email;
                $cacher->phone = $user->phone;
                if ($user->image) {
                    $cacher->image = env('APP_URL').'Admin/images/cachers/'.$user->image;
                }
                else {
                    $cacher->image = env('APP_URL').'Admin/images/users/user.png';
                }
                array_push($usersData, $cacher);
            }
        }
        return view('Admin.reports.countOrdersCacher', compact('totalUser', 'totalorders', 'total_saleToday', 'usersData'));
    }

    public function countOrdersSellers()
    {
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }

        $total = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->sum('total');
        $delivary = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->sum('delivary');
        $total_sale = $total + $delivary;

        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $sum = 0;
        $numbers_of_orders = $this->bdModel::SELECT("select id, count(*) as count, date(created_at) as date, sum(total) as total, sum(delivary) as delivary, seller_id as seller_id from orders WHERE status=1 AND date(created_at) >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY date(created_at) ORDER BY count DESC");
        foreach ($numbers_of_orders as $order) {
            if ($order->seller_id == $shop->user_id) {
                $sum += $order->total;
                $sum += $order->delivary;
            }
        }
        $productData = [];
        $products = $this->orderDetialsModel::select('product_id' , $this->orderDetialsModel::raw('COUNT(product_id) as count'))->groupBy('product_id')->orderBy('count' , 'DESC')->paginate(5);
        foreach ($products as $product) {
            $data = $this->productModel::find($product->product_id);
            $menue = $this->menueModel::find($data->subMenue->menue_id);
            if ($menue->shop_id == $shop->id) {
                $product->image = env('APP_URL') . 'Admin/images/products/'.$product->product->image;
                $product->view = $product->product->view;
                if (app()->getLocale() == "ar") {
                    $product->name = $product->product->name_ar;
                }
                else {
                    $product->name = $product->product->name_en;
                }
                $product->rate = (int)ProductCommenet::where('product_id', $product->id)->avg('rate');
                array_push($productData, $product);
            }
        }
        $cities = [];
        $regions = $this->orderModel::select('address_id', 'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'seller_id' => $shop->user_id])->paginate(5);
        foreach ($regions as $region) {
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
        }
        return view('Seller.reports.counorders', compact('total_sale', 'total_saleToday', 'sum', 'numbers_of_orders', 'productData', 'regions'));
    }

    public function countOrdersClientSellers()
    {
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $totalorders = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->count();
        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1, 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;

        $users = $this->orderModel::select('user_id', $this->orderModel::raw('COUNT(user_id) as count'))->groupBy('user_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'seller_id' => $shop->user_id])->paginate(5);
        foreach ($users as $user) {
            if ($user->user->image) {
                $user->image = env('APP_URL').'Admin/images/users/'.$user->user->image;
            }
            else {
                $user->image = env('APP_URL').'Admin/images/users/user.png';
            }
        }
        $regions = $this->orderModel::select('address_id' ,'updated_at', $this->orderModel::raw('COUNT(address_id) as count'))->groupBy('address_id')->orderBy('count' , 'DESC')->where(['status' => 1])->paginate(5);
        foreach ($regions as $region) {
            $address = $this->userAddressModel::find($region->address_id);
            $region->city = $address->city;
            $region->from = $this->carbonModel::parse($region->updated_at)->format('g:i a');
            $region->to = $this->carbonModel::parse($region->updated_at)->addHours(2)->format('g:i a');
        }
        return view('Seller.reports.countOrdersClient', compact('totalorders', 'total_saleToday', 'users', 'regions'));
    }
    public function countOrdersCacherSeller()
    {
        $totalUser = 0;
        $role = $this->roleModel::where('name', 'Casher')->first();
        $users = $this->userModel::where('role_id', $role->id)->get();
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        foreach ($users as $user) {
            $cacher = $this->cacherDetialsModel::where('shop_id', $shop->id)->first();
            if ($cacher) {
                $totalUser += 1;
            }
        }
        $totalorders = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done', 'seller_id' => $shop->user_id])->count();

        $date = $this->carbonModel::now(); // or whatever you're using to set it
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $totalToday = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done', 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('total');
        $delivaryToday = $this->orderModel::where(['status' => 1, 'orderStatus' => 'done', 'seller_id' => $shop->user_id])->whereBetween('updated_at', [$start, $end])->sum('delivary');
        $total_saleToday = $totalToday + $delivaryToday;
        $usersData = [];
        $users = $this->orderModel::select('cacher_id', $this->orderModel::raw('COUNT(cacher_id) as count'))->groupBy('cacher_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'orderStatus' => 'done', 'seller_id' => $shop->user_id])->paginate(5);
        foreach ($users as $cacher) {
            $user = $this->userModel::find($cacher->cacher_id);
            if ($user) {
                $cacher->name = $user->name;
                $cacher->id = $user->id;
                $cacher->email = $user->email;
                $cacher->phone = $user->phone;
                if ($user->image) {
                    $cacher->image = env('APP_URL').'Admin/images/cachers/'.$user->image;
                }
                else {
                    $cacher->image = env('APP_URL').'Admin/images/users/user.png';
                }
                array_push($usersData, $cacher);
            }
        }
        return view('Seller.reports.countOrdersCacher', compact('totalUser', 'totalorders', 'total_saleToday', 'usersData'));
    }

    public function filterResturants(Request $request)
    {
        $resturants = [];
        $categoryResturant = $this->categoryModel::where('name_en', 'Resturant')->first();
        $resturantsData = $this->orderModel::select('seller_id', 'updated_at', $this->orderModel::raw('COUNT(seller_id) as count'))->groupBy('seller_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'address_id' => $request->region_id])->get();
        foreach ($resturantsData as $dataStore) {
            $dataStore->from = $this->carbonModel::parse($dataStore->updated_at)->format('g:i a');
            $dataStore->to = $this->carbonModel::parse($dataStore->updated_at)->addHours(2)->format('g:i a');
            $shop = $this->shopModel::where(['user_id' => $dataStore->seller->id, 'status' => 1, 'category_id' => $categoryResturant->id])->first();
            if ($shop) {
                if (count($resturants) < 5) {
                    $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                if (app()->getLocale() == "ar") {
                    $dataStore->name = $shop->name_ar;
                }
                else {
                    $dataStore->name = $shop->name_en;
                }
                array_push($resturants, $dataStore);
                }
            }
        }
        $data = json_encode($resturants);
        return $data;
    }
    public function filterStore(Request $request)
    {
        $resturants = [];
        $categoryResturant = $this->categoryModel::where('name_en', 'Resturant')->first();
        $resturantsData = $this->orderModel::select('seller_id', 'updated_at', $this->orderModel::raw('COUNT(seller_id) as count'))->groupBy('seller_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'address_id' => $request->region_id])->get();
        foreach ($resturantsData as $dataStore) {
            $dataStore->from = $this->carbonModel::parse($dataStore->updated_at)->format('g:i a');
            $dataStore->to = $this->carbonModel::parse($dataStore->updated_at)->addHours(2)->format('g:i a');
            $shop = $this->shopModel::where(['user_id' => $dataStore->seller->id, 'status' => 1])->where('category_id', '!=', $categoryResturant->id)->first();
            if ($shop) {
                if (count($resturants) < 5) {
                    $dataStore->image = env('APP_URL').'Admin/images/shop/'.$shop->logo;
                if (app()->getLocale() == "ar") {
                    $dataStore->name = $shop->name_ar;
                }
                else {
                    $dataStore->name = $shop->name_en;
                }
                array_push($resturants, $dataStore);
                }
            }
        }
        $data = json_encode($resturants);
        return $data;
    }

    public function filterClient(Request $request)
    {
        $users = $this->orderModel::select('user_id', 'updated_at', $this->orderModel::raw('COUNT(user_id) as count'))->groupBy('user_id')->orderBy('count' , 'DESC')->where(['status' => 1, 'address_id' => $request->region_id])->get();
        foreach ($users as $user) {
            $user->from = $this->carbonModel::parse($user->updated_at)->format('g:i a');
            $user->to = $this->carbonModel::parse($user->updated_at)->addHours(2)->format('g:i a');
            if ($user->user->image) {
                $user->image = env('APP_URL').'Admin/images/users/'.$user->user->image;
            }
            else {
                $user->image = env('APP_URL').'Admin/images/users/user.png';
            }
            $user->name = $user->user->name;
            $user->email = $user->user->email;
            $user->phone = $user->user->phone;
        }
        $data = json_encode($users);
        return $data;
    }
}
