@extends('adminLayout')

@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.settings') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header.png') }}" alt="header"
                class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header1.png') }}" alt="header"
                class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header2.png') }}" alt="header"
                class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header3.png') }}" alt="header"
                class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header4.png') }}" alt="header"
                class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header5.png') }}" alt="header"
                class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span> {{ __('dashboard.nameandLogo') }}</span>
                            </div>
                        </div>
                        @include('partials._logo')
                        @include('partials._errors')
                        <div style="padding: 20px">
                            <form id="logo-form" class="was-validated" action="{{ route('nameandLogo') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-md-8">
                                    <label for="validationTextarea" style="font-size: 20px"
                                        class="form-label"><b>{{ __('dashboard.webName') }}</b></label>
                                    <input type="text" name="webName" id="webName" class="form-control is-invalid"
                                        placeholder="{{ __('dashboard.webName') }}" value="{{ $title->value }}">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="validationTextarea" style="font-size: 20px"
                                        class="form-label"><b>{{ __('dashboard.webLogo') }}</b></label>
                                    <input type="file" name="webLogo" id="name" class="form-control is-invalid"
                                        placeholder="{{ __('dashboard.webLogo') }}">
                                </div>
                                <img width="100px" src="{{ asset('Admin/images/logo/' . $logo->value) }}" alt="logo">
                            </form>
                            <div class="modal-footer">
                                <button form="logo-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                        @include('partials._firebase')
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span> {{ __('dashboard.firebaseSetting') }}</span>
                            </div>
                        </div>
                        <div style="padding: 20px">
                            <form id="submit-form" class="was-validated" action="{{ route('firebaseUpdate') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea" style="font-size: 20px"
                                        class="form-label"><b>{{ __('dashboard.firebasekey') }}</b></label>
                                    <textarea class="form-control is-invalid" name="firebaseKey" id="firebaseKey" cols="30" rows="3" required>{{ $firebaseKey->value }}</textarea>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button form="submit-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                        @include('partials._sms')
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span>{{ __('dashboard.emailSetting') }}</span>
                            </div>
                        </div>
                        <div style="padding: 20px">
                            <form id="sms-form" class="was-validated" action="{{ route('smsUpdate') }}" method="POST">
                                @csrf
                                @foreach ($smsSettings as $smsSetting)
                                    @if ($smsSetting->key == 'MAIL_USERNAME')
                                        <div class="form-group">
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.MAIL_USERNAME') }}</label>
                                            <input class="form-control is-invalid" id="validationTextarea"
                                                placeholder="{{ __('dashboard.MAIL_USERNAME') }}" type="text"
                                                name="MAIL_USERNAME" required value="{{ $smsSetting->value }}">
                                        </div>
                                    @elseif ($smsSetting->key == 'MAIL_PASSWORD')
                                        <div class="form-group">
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.MAIL_PASSWORD') }}</label>
                                            <input class="form-control is-invalid" id="validationTextarea"
                                                placeholder="{{ __('dashboard.MAIL_PASSWORD') }}" type="text"
                                                name="MAIL_PASSWORD" required value="{{ $smsSetting->value }}">
                                        </div>
                                    @elseif ($smsSetting->key == 'MAIL_FROM_ADDRESS')
                                        <div class="form-group">
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.MAIL_FROM_ADDRESS') }}</label>
                                            <input class="form-control is-invalid" id="validationTextarea"
                                                placeholder="{{ __('dashboard.MAIL_FROM_ADDRESS') }}" type="email"
                                                name="MAIL_FROM_ADDRESS" required value="{{ $smsSetting->value }}">
                                        </div>
                                    @elseif ($smsSetting->key == 'MAIL_HOST')
                                        <div class="form-group">
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.MAIL_HOST') }}</label>
                                            <input class="form-control is-invalid" id="validationTextarea"
                                                placeholder="{{ __('dashboard.MAIL_HOST') }}" type="text"
                                                name="MAIL_HOST" required value="{{ $smsSetting->value }}">
                                        </div>
                                    @endif
                                @endforeach
                            </form>
                            <div class="modal-footer">
                                <button form="sms-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                        @include('partials._price')
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span>عدد النقاط عند تسجيل حساب جديد</span>
                            </div>
                        </div>
                        <div style="padding: 20px">
                            <form id="price-form" class="was-validated" action="{{ route('points') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">عدد النقاط</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="عدد النقاط" type="number" min="0" step="1"
                                        name="points" required value="{{ $points->value }}">
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button form="price-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                        
                        @include('partials._home')
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span>وصف الصفحة الرئيسية</span>
                            </div>
                        </div>
                        <div style="padding: 20px">
                            <form id="home-form" class="was-validated" action="{{ route('homw_desc') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">العنوان</label>
                                    <textarea class="form-control is-invalid" id="validationTextarea" placeholder="العنوان"
                                        name="desc" required>{{ $home->value }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">الوصف</label>
                                    <textarea class="form-control is-invalid" id="validationTextarea" placeholder="الوصف"
                                        name="title" required>{{ $desc->value }}</textarea>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button form="home-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                        
                        @include('partials._addition_value')
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                <span>القيمة المضافة</span>
                            </div>
                        </div>
                        <div style="padding: 20px">
                            <form id="addition-form" class="was-validated" action="{{ route('addition_value') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">القيمة المضافة</label>
                                    <input class="form-control is-invalid" id="validationTextarea" placeholder="القيمة المضافة"
                                        name="addition_value" required value="{{ $addition_value->value }}">
                                </div>
                                
                            </form>
                            <div class="modal-footer">
                                <button form="addition-form" type="submit"
                                    class="btn btn-primary">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
