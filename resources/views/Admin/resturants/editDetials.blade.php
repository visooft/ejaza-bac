@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.updateProduct') }}</h1>
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
                <div class="col-sm-12" style="margin-top: 10px;">
                    <div class="card">
                        @include('partials._session')
                        @include('partials._errors')

                        <div class="modal-body">
                            <div class="card-body col-md-8">

                                <form id="update-form" class="was-validated" action="{{ route('resturants.update') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="resturantId" id="resturantUpdate"
                                        value="{{ $resturant->id }}">
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.name_ar') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->name_ar)) is-valid @else is-invalid @endif"
                                            id="name_ar" placeholder="{{ __('dashboard.name_ar') }}" type="text"
                                            name="name_ar" value="{{ $resturant->name_ar }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.name_en') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->name_en)) is-valid @else is-invalid @endif"
                                            id="name_en" placeholder="{{ __('dashboard.name_en') }}" type="text"
                                            name="name_en" required value="{{ $resturant->name_en }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                        <textarea name="desc_ar" class="form-control @if (isset($resturant->desc_ar)) is-valid @else is-invalid @endif"
                                            id="desc_ar" cols="30" rows="3" required placeholder="{{ __('dashboard.desc_ar') }}">{{ $resturant->desc_ar }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.desc_en') }}</label>
                                        <textarea name="desc_en" class="form-control @if (isset($resturant->desc_en)) is-valid @else is-invalid @endif"
                                            id="desc_en" cols="30" rows="3" required placeholder="{{ __('dashboard.desc_en') }}">{{ $resturant->desc_en }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.resturnOwnerPhone') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->phone)) is-valid @else is-invalid @endif"
                                            id="userPhone" placeholder="{{ __('dashboard.resturnOwnerPhone') }}"
                                            maxlength="10" name="phone" pattern="[0-9]+"
                                            title="{{ __('dashboard.resturnOwnerPhone') }}" type="tel" required
                                            value="{{ $resturant->phone }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.lat') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->lat)) is-valid @else is-invalid @endif"
                                            id="restLat" placeholder="{{ __('dashboard.lat') }}" name="lat"
                                            title="{{ __('dashboard.lat') }}" type="number" min="0"
                                            step="0.000000001" required value="{{ $resturant->lat }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.long') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->long)) is-valid @else is-invalid @endif"
                                            id="restLong" placeholder="{{ __('dashboard.long') }}" maxlength="10"
                                            name="long" title="{{ __('dashboard.long') }}" type="number"
                                            step="0.000000001" min="0" required value="{{ $resturant->long }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.address') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->address)) is-valid @else is-invalid @endif"
                                            id="restAddress" placeholder="{{ __('dashboard.address') }}" name="address"
                                            type="text" required value="{{ $resturant->address }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.link') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->link)) is-valid @else is-invalid @endif"
                                            id="restLink" placeholder="{{ __('dashboard.link') }}" name="link"
                                            type="url" value="{{ $resturant->link }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.resturnPhone') }}</label>
                                        <input
                                            class="form-control @if (isset($resturant->resturantPhone)) is-valid @else is-invalid @endif"
                                            id="resetPhone" placeholder="{{ __('dashboard.resturnPhone') }}"
                                            maxlength="10" name="resturnPhone" pattern="[0-9]+"
                                            title="{{ __('dashboard.resturnPhone') }}" type="tel" required
                                            value="{{ $resturant->resturantPhone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.delivaryCost') }}
                                            ({{ __('dashboard.Rial') }})</label>
                                        <input
                                            class="form-control @if (isset($resturant->delivaryCost)) is-valid @else is-invalid @endif"
                                            id="restCost" placeholder="{{ __('dashboard.delivaryCost') }}"
                                            name="delivaryCost" title="{{ __('dashboard.delivaryCost') }}"
                                            type="number" min="0" step="0.1" required
                                            value="{{ $resturant->delivaryCost }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea" class="form-label">{{ __('dashboard.time') }}
                                            ({{ __('dashboard.minute') }})</label>
                                        <input
                                            class="form-control @if (isset($resturant->time)) is-valid @else is-invalid @endif"
                                            id="restTime" placeholder="{{ __('dashboard.time') }}" maxlength="10"
                                            name="time" title="{{ __('dashboard.time') }}" type="number"
                                            min="0" step="0.1" required value="{{ $resturant->time }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.category') }}</label>
                                        <br>
                                        @php
                                            $shopsubs = \App\Models\ShopSub::where('shop_id', $resturant->id)->pluck('sub_category_id');
                                        @endphp
                                        @foreach ($subCategories as $category)
                                            <label class="checkbox-inline">
                                                <input id="checkBox" type="checkbox" class="chk-box"
                                                    name="subCategories[]" value="{{ $category->id }}"
                                                    @foreach ($shopsubs as $sub)
                                            @if ($sub == $category->id)
                                                <?= 'checked' ?>
                                            @endif @endforeach>
                                                {{ $category->name }}
                                            </label>
                                            <br>
                                        @endforeach
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="validationTextarea" class="form-label">{{ __('dashboard.logo') }}
                                            (jpeg,jpg,png,gif,webp)*</label>
                                        <input name="logo" type="file"
                                            class="form-control @if (isset($resturant->logo)) is-valid @else is-invalid @endif"
                                            aria-label="file example">
                                        <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.backGround') }}
                                            (jpeg,jpg,png,gif,webp)*</label>
                                        <input name="backGround" type="file"
                                            class="form-control @if (isset($resturant->backGround)) is-valid @else is-invalid @endif"
                                            aria-label="file example">
                                        <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                            <button form="update-form" type="submit"
                                class="btn btn-primary">{{ __('dashboard.save') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br><br>
    @endsection
