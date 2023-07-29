<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\getLang;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\paymentTrait;
use App\Http\Traits\smsTrait;
use App\Http\Services\FatoorahService;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Notifications;
use App\Models\Otp;
use App\Models\Housing;
use App\Models\Order;
use App\Models\Roles;
use App\Models\Setting;
use App\Models\Offers;
use App\Models\Coupon;
use App\Models\Wallet;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Moyasar\Moyasar;

class AuthController extends Controller
{
    use GeneralTrait, getLang, ImagesTrait, smsTrait, paymentTrait;

    private $userModel, $appModel, $validateModel, $otpModel, $countryModel, $hashModel, $roleModel, $fatoorahService;

    public function __construct(Validator $validate, User $user, App $app, Otp $otp, Country $country, Hash $hash, Roles $role, FatoorahService $fatoorahService)
    {
        $this->validateModel = $validate;
        $this->userModel = $user;
        $this->appModel = $app;
        $this->countryModel = $country;
        $this->otpModel = $otp;
        $this->hashModel = $hash;
        $this->roleModel = $role;
        $this->fatoorahService = $fatoorahService;
    }

    public function login(Request $request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'phone' => 'required|numeric|exists:users,phone',
                'password' => 'required|min:8',
                'device_token' => 'required',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if (auth()->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                $user = $this->userModel::where(['phone' => $request->phone])->first();
                if ($user->status == 0) {
                    $otp = rand(1111, 9999);
                    if ($request->phone[0] == 0) {
                        $mobile = "966" . substr($request->phone, 1);
                    } else {

                        $index = substr($request->phone, 0, 3);
                        if ($index != 966) {
                            $mobile = "966" . substr($request->phone, 3);
                        }
                    }
                    $responce = $this->_fireSMS($mobile, $otp);
                    $data = json_decode($responce);
                    if ($data->status == "F") {
                        return $this->returnError(403, 'برجاء مراجعة الدعم الفني');
                    }
                    $token = $user->createToken("API TOKEN")->plainTextToken;
                    $token = "Bearer " . $token;
                    $user->update(['device_token' => $request->device_token, 'token' => $token]);
                    $this->otpModel::where(['phone' => $request->phone])->delete();
                    $this->otpModel::create([
                        'otp' => $otp,
                        'phone' => $request->phone,
                    ]);
                    $data = $this->userModel::where(['phone' => $request->phone])->first(['name', 'email', 'phone', 'link', 'image', 'gender', 'nationality', 'birth_date']);
                    $data->token = $token;
                    $city = $this->countryModel::find($user->country_id);
                    if ($lang == "en") {
                        $data->country = $city->name_en;
                        $data->currency = $en->translate($city->currency);
                    } elseif ($lang == "tr") {
                        $data->country = $city->name_tr;
                        $data->currency = $tr->translate($city->currency);
                    } else {
                        $data->country = $city->name_ar;
                        $data->currency = $city->currency;
                    }

                    if ($data->image) {
                        $data->image = env('APP_URL') . 'Admin/images/users/' . $data->image;
                    } else {
                        $data->image = "https://ui-avatars.com/api/?name=" . $data->name . ".png";
                    }
                    return $this->returnData('data', ['user' => $data, 'code' => $otp, 'isActive' => 0], __('api.verifyAccount'));
                }
                $token = $user->createToken("API TOKEN")->plainTextToken;
                $token = "Bearer " . $token;
                if (!$token) {
                    return $this->returnError(401, __('api.notAllow'));
                }
                $user->update(['device_token' => $request->device_token, 'token' => $token]);
                $data = $this->userModel::where(['phone' => $request->phone])->first(['name', 'email', 'phone', 'link', 'image', 'gender', 'nationality', 'birth_date']);
                $data->token = $token;
                $city = $this->countryModel::find($user->country_id);
                if ($lang == "en") {
                    $data->country = $city->name_en;
                    $data->currency = $en->translate($city->currency);
                } elseif ($lang == "tr") {
                    $data->country = $city->name_tr;
                    $data->currency = $tr->translate($city->currency);
                } else {
                    $data->country = $city->name_ar;
                    $data->currency = $city->currency;
                }
                ($data->gender) ?: $data->gender = "";
                ($data->nationality) ?: $data->nationality = "";
                ($data->birth_date) ?: $data->birth_date = "";
                if ($data->image) {
                    $data->image = env('APP_URL') . 'Admin/images/users/' . $data->image;
                } else {
                    $data->image = "https://ui-avatars.com/api/?name=" . $data->name . ".png";
                }
                return $this->returnData('data', ['user' => $data, 'isActive' => 1], __('api.successLogin'));
            }
            return $this->returnError(401, __('api.notAllow'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function register(Request $request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'name' => 'required|string|min:3|max:100',
                'gender' => 'required|in:0,1',
                'nationality' => 'required|string|min:3|max:100',
                'birth_date' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|unique:users,phone',
                'country_id' => 'required|exists:countries,id',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->password != $request->confirm_password) {
                return $this->returnError(403, __('api.notConfirm'));
            }
            $role = $this->roleModel::where('name', 'User')->first();
            $this->userModel::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $this->hashModel::make($request->password),
                'country_id' => $request->country_id,
                'role_id' => $role->id,
                'gender' => $request->gender,
                'nationality' => $request->nationality,
                'birth_date' => $request->birth_date,
                'link' => "https://visooft-code.com",
                'points' => Setting::where('key', 'points')->first()->value,
            ]);
            $user = $this->userModel::where(['phone' => $request->phone])->first();
            $otp = rand(1111, 9999);
            if ($request->phone[0] == 0) {
                $mobile = "966" . substr($request->phone, 1);
            } else {

                $index = substr($request->phone, 0, 3);
                if ($index != 966) {
                    $mobile = "966" . substr($request->phone, 3);
                }
            }
            $responce = $this->_fireSMS($mobile, $otp);
            $data = json_decode($responce);
            if ($data) {
                if ($data->status == "F") {
                    return $this->returnError(403, 'برجاء مراجعة الدعم الفني');
                }
            }

            $token = $user->createToken("API TOKEN")->plainTextToken;
            $this->otpModel::create([
                'otp' => $otp,
                'phone' => $request->phone,
            ]);
            $token = "Bearer " . $token;
            $data = $this->userModel::where(['phone' => $request->phone])->first(['name', 'email', 'phone', 'link', 'image', 'gender', 'nationality', 'birth_date']);
            $data->token = $token;
            $user->update(['token' => $token]);
            $city = $this->countryModel::find($user->country_id);
            if ($lang == "en") {
                $data->country = $city->name_en;
                $data->currency = $en->translate($city->currency);
            } elseif ($lang == "tr") {
                $data->country = $city->name_tr;
                $data->currency = $tr->translate($city->currency);
            } else {
                $data->country = $city->name_ar;
                $data->currency = $city->currency;
            }
            if ($data->image) {
                $data->image = env('APP_URL') . 'Admin/images/users/' . $data->image;
            } else {
                $data->image = "https://ui-avatars.com/api/?name=" . $data->name . ".png";
            }
            return $this->returnData('data', ['user' => $data, 'code' => $otp, 'isActive' => 0], __('api.verifyAccount'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }


    function verifyOtp(Request $request)
    {
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'otp' => 'required|numeric|digits:4',
                'device_token' => 'required'
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $otp = $this->otpModel::where(['otp' => $request->otp, 'phone' => $request->user()->phone])->first();
            if ($otp) {
                $token = $request->user()->createToken("API TOKEN")->plainTextToken;
                $token = "Bearer " . $token;
                $user = $request->user();
                $user = $this->userModel::where(['phone' => $user->phone])->first();
                $user->update(['status' => 1, 'device_token' => $request->device_token, 'token' => $token]);
                $data = $this->userModel::where(['phone' => $user->phone])->first(['name', 'email', 'phone', 'link', 'image', 'gender', 'nationality', 'birth_date']);
                $data->token = $token;
                $city = $this->countryModel::find($request->user()->country_id);
                if ($lang == "en") {
                    $data->country = $city->name_en;
                    $data->currency = $en->translate($city->currency);
                } elseif ($lang == "tr") {
                    $data->country = $city->name_tr;
                    $data->currency = $tr->translate($city->currency);
                } else {
                    $data->country = $city->name_ar;
                    $data->currency = $city->currency;
                }
                if ($data->image) {
                    $data->image = env('APP_URL') . 'Admin/images/users/' . $data->image;
                } else {
                    $data->image = "https://ui-avatars.com/api/?name=" . $data->name . ".png";
                }
                $otp->delete();
                return $this->returnData('data', ['user' => $data, 'isActive' => 1], __('api.successLogin'));
            }
            return $this->returnError(403, __('api.invalidOtp'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function resendOtp(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $this->otpModel::where('phone', $request->user()->phone)->delete();
            $otp = rand(1111, 9999);
            if ($request->user()->phone[0] == 0) {
                $mobile = "966" . substr($request->user()->phone, 1);
            } else {

                $index = substr($request->user()->phone, 0, 3);
                if ($index != 966) {
                    $mobile = "966" . substr($request->user()->phone, 3);
                }
            }
            $responce = $this->_fireSMS($mobile, $otp);
            $data = json_decode($responce);
            if ($data->status == "F") {
                return $this->returnError(403, 'برجاء مراجعة الدعم الفني');
            }
            $this->otpModel::create([
                'otp' => $otp,
                'phone' => $request->user()->phone,
            ]);
            return $this->returnSuccess(200, __('api.resendOtp'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function forgetPassword(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'phone' => 'required|numeric|exists:users,phone',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $this->otpModel::where('phone', $request->phone)->delete();
            $otp = rand(1111, 9999);
            if ($request->phone[0] == 0) {
                $mobile = "966" . substr($request->phone, 1);
            } else {

                $index = substr($request->phone, 0, 3);
                if ($index != 966) {
                    $mobile = "966" . substr($request->phone, 3);
                }
            }
            $responce = $this->_fireSMS($mobile, $otp);
            $data = json_decode($responce);
            if ($data->status == "F") {
                return $this->returnError(403, 'برجاء مراجعة الدعم الفني');
            }
            $this->otpModel::create([
                'otp' => $otp,
                'phone' => $request->phone,
            ]);
            return $this->returnSuccess(200, __('api.resendOtp'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function changePassword(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'phone' => 'required|numeric|exists:users,phone',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->password != $request->confirm_password) {
                return $this->returnError(403, __('api.notConfirm'));
            }
            $user = $this->userModel::where('phone', $request->phone)->first();
            $user->update([
                'password' => $this->hashModel::make($request->password),
            ]);

            return $this->returnSuccess(200, __('api.changePassword'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function logout(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $user = request()->user();

            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return $this->returnSuccess(200, __('api.logout'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function deleteAccount(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $user = request()->user();

            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

            $userData = User::find($user->id);
            $userData->forcedelete();
            return $this->returnSuccess(200, __('api.deleteAccount'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function updateProfile(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'name' => 'nullable|string|min:3|max:200',
                'email' => 'nullable|email|unique:users,email,' . $request->user()->id,
                'country_id' => 'nullable|exists:countries,id',
                'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
                'gender' => 'nullable|in:0,1',
                'nationality' => 'nullable|string|min:3|max:100',
                'birth_date' => 'nullable',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->image) {
                $imageName = time() . '_user.' . $request->image->extension();

                $this->uploadImage($request->image, $imageName, 'users');
            } else {
                $imageName = $request->user()->image;
            }
            if ($request->name) {
                $name = $request->name;
            } else {
                $name = $request->user()->name;
            }
            if ($request->email) {
                $email = $request->email;
            } else {
                $email = $request->user()->email;
            }
            if ($request->country_id) {
                $country_id = $request->country_id;
            } else {
                $country_id = $request->user()->country_id;
            }
            if ($request->birth_date) {
                $birth_date = $request->birth_date;
            } else {
                $birth_date = $request->user()->birth_date;
            }
            if ($request->gender) {
                $gender = $request->gender;
            } else {
                $gender = $request->user()->gender;
            }
            if ($request->nationality) {
                $nationality = $request->nationality;
            } else {
                $nationality = $request->user()->nationality;
            }
            $user = $this->userModel::find($request->user()->id);
            $user->update([
                'name' => $name,
                'email' => $email,
                'country_id' => $country_id,
                'image' => $imageName,
                'gender' => $gender,
                'nationality' => $nationality,
                'birth_date' => $birth_date,
            ]);
            $user = $this->userModel::find($request->user()->id);
            if ($user->image) {
                $user->image = env('APP_URL') . 'Admin/images/users/' . $user->image;
            } else {
                $user->image = "https://ui-avatars.com/api/?name=" . $user->name . ".png";
            }
            return $this->returnData('data', ['image' => $user->image], __('api.updateProfile'));
            return $this->returnSuccess(200, __('api.updateProfile'));
        } catch (\Throwable $th) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public function getProfileData(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $data = $this->userModel::where(['id' => $request->user()->id])->first(['name', 'email', 'phone', 'link', 'image', 'country_id', 'gender', 'nationality', 'birth_date']);
            $city = $this->countryModel::find($data->country_id);
            if ($lang == "en") {
                $data->country = $city->name_en;
            } elseif ($lang == "tr") {
                $data->country = $city->name_tr;
            } else {
                $data->country = $city->name_ar;
            }
            if ($data->image) {
                $data->image = env('APP_URL') . 'Admin/images/users/' . $data->image;
            } else {
                $data->image = "https://ui-avatars.com/api/?name=" . $data->name . ".png";
            }
            return $this->returnData('data', ['user' => $data], __('api.successLogin'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'old_password' => 'required|min:8',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8',
            ];

            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->password != $request->confirm_password) {
                return $this->returnError(403, __('api.notConfirm'));
            }
            if (!$this->hashModel::check($request->cuurnt_password, $request->user()->password)) {
                return $this->returnError(403, __('api.wrongpassword'));
            }
            $user = $this->userModel::where('id', $request->user()->id)->first();
            $user->update([
                'password' => $this->hashModel::make($request->password),
            ]);
            return $this->returnSuccess(200, __('api.updatePassword'));
        } catch (\Exception $e) {
            return $this->returnError(403, __('api.errorMessage'));
        }
    }

    public $addition_value;

    public function order(Request $request)
    {
        // require_once env('APP_URL').'en/autoload.php';
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'count' => 'required|numeric',
                'house_id' => 'required|exists:housings,id',
                'from' => 'nullable|string',
                'to' => 'nullable|string',
                'lat' => 'nullable|string',
                'long' => 'nullable|string',
                'date' => 'nullable|string',
                'time' => 'nullable|string',
                'name' => 'nullable|string',
                'email' => 'nullable|string',
                'phone' => 'nullable|string',
                'payment_type' => 'required|in:cash,online,wallet',
                'status' => 'required|in:0,1',
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 6; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $house = Housing::find($request->house_id);
            if ($house->category_id == 6) {
                $house->update([
                    'ticket_count' => $house->ticket_count - $request->count,
                ]);
            }
            if ($house->category_id == 3 || $house->category_id == 4 || $house->category_id == 5) {
                if ($request->status == 1) {
                    $house->update([
                        'is_pay' => 1,
                    ]);
                }
            }
            $offer = Offers::where('housings_id', $house->id)->first();
            if ($offer) {
                $price = $house->price - ($house->price * $offer->offer / 100);
                $totalPrice = $price * $request->count;
            } else {
                $setting = Setting::all();
                foreach ($setting as $settin) {
                    if ($settin->key == "addition_value") {
                        $this->addition_value = $settin->value;
                    }
                }
                $totalPrice = $house->price * $request->count * $request->passengers + $this->addition_value;
            }
            if ($request->coupon) {
                $coupon = Coupon::where('coupon', $request->coupon)->first();
                $total = $totalPrice - ($totalPrice * $coupon->offer / 100);
            } else {
                $total = $totalPrice;
            }
            if ($request->payment_type == "wallet") {
                $wallet = $request->user()->wallet;
                if ($total > $wallet) {
                    return $this->returnErrorData('data', ['payment_type' => $request->payment_type], __('api.notEnugth'));
                } else {
                    $user = $this->userModel::find($request->user()->id);
                    $user->update([
                        'wallet' => $user->wallet - $total,
                    ]);
                    Wallet::create([
                        'desc_ar' => 'تم خضم ' . $total . ' ريال سعودي من المحفظة الخاصة بك    ',
                        'desc_en' => ' has been rival ' . $total . ' SAR from your wallet',
                        'desc_tr' => ' rakip ' . $total . ' SAR eklendi',
                        'user_id' => $request->user()->id
                    ]);
                }
            }

            Order::create([
                'orderNumber' => $randomString,
                'user_id' => $request->user()->id,
                'housings_id' => $request->house_id,
                'from' => $request->from,
                'to' => $request->to,
                'count' => $request->count,
                'total' => $total,
                'lat' => $request->lat,
                'long' => $request->long,
                'date' => $request->date,
                'time' => $request->time,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'payment_type' => $request->payment_type,
            ]);

            Notifications::create([
                'user_id' => $house->user_id,
                'subject' => 'تم حجز خدمتك بنجاح',
                'message' => 'تم حجز خدمتك بنجاح من قبل العميل' . $request->user()->name,
            ]);

            $firebaseToken = User::where('id', $house->user_id)->pluck('device_token')->toArray();
            $setting = Setting::where('key', 'firebaseKey')->first();
            if ($setting) {
                $SERVER_API_KEY = $setting->value;
            }

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => "تم حجز خدمتك بنجاح",
                    "body" => "تم حجز خدمتك بنجاح من قبل العميل" . $request->user()->name,
                ]
            ];

            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);

            return $this->returnData('data', ['payment_type' => $request->payment_type], __('api.successOrder'));
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function addCoupon(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'coupon' => 'required|exists:coupons,coupon'
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $coupon = Coupon::where('coupon', $request->coupon)->first();
            if (!$coupon) {
                if (app()->getLocale() == "ar") {
                    return $this->returnError(403, "كود الخصم غير صحيح");
                } elseif (app()->getLocale() == "en") {
                    return $this->returnError(403, "The discount code is incorrect");
                } else {
                    return $this->returnError(403, "İndirim kodu yanlış");
                }
            } else {
                $date1 = strtotime(date($coupon->end));

                $date2 = strtotime(date("Y-m-d"));
                if ($date1 >= $date2) {
                    $date = 0;
                } else {
                    $date = 1;
                }
                if ($coupon->counUsed == $coupon->count || $date) {
                    if (app()->getLocale() == "ar") {
                        return $this->returnError(403, "تم انتهاء صلاحية الكود الخاص بك");
                    } elseif (app()->getLocale() == "en") {
                        return $this->returnError(403, "Your code has expired");
                    } else {
                        return $this->returnError(403, "Kodunuzun süresi doldu");
                    }
                } else {
                    $coupon->update([
                        'counUsed' => $coupon->counUsed + 1
                    ]);
                    if (app()->getLocale() == "ar") {
                        return $this->returnData('data', ['discount' => $coupon->offer], 'تم تنفيذ كوبون الخصم الخاص بك');
                    } elseif (app()->getLocale() == "en") {
                        return $this->returnData('data', ['discount' => $coupon->offer], 'Your discount coupon has been executed');
                    } else {
                        return $this->returnData('data', ['discount' => $coupon->offer], 'İndirim Kuponunuz Gerçekleştirildi');
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function changeCounry(Request $request)
    {
        $lang = $this->returnLang($request);
        $this->appModel::setLocale($lang);
        try {
            $rules = [
                'country_id' => 'required|exists:countries,id'
            ];
            $validator = $this->validateModel::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $country = Country::find($request->country_id);
            if (!$country) {
                return $this->returnError(403, 'هذا البلد غير موجود');
            } else {
                $user = User::find(auth()->id());
                $user->update([
                    'country_id' => $request->country_id
                ]);
            }
            return $this->returnData('data', null, 'تم تغيير البلد بنجاح');
        } catch (\Exception $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }


    public function contact()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ ما',
                'data' => $validator->errors(),
            ]);
        }
        try {
            $data = new Contact();
            $data->name = request()->name;
            $data->email = strtolower(request()->email);
            $data->phone = request()->phone;
            $data->message = request()->message;
            $data->subjecet = request()->subject;
            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'تم ارسال الرسالة بنجاح',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ ما',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
