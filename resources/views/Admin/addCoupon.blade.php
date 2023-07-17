@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.addCoupon') }}</h1>
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

                                <form id="submit-form" class="was-validated" action="{{ route('coupon.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.coupon') }}</label>
                                        <input class="form-control is-invalid" id="validationTextarea"
                                            placeholder="{{ __('dashboard.coupon') }}" type="text" name="coupon"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.start') }}</label>
                                        <input class="form-control is-invalid" id="validationTextarea"
                                            placeholder="{{ __('dashboard.start') }}" type="date" name="start"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.end') }}</label>
                                        <input class="form-control is-invalid" id="validationTextarea"
                                            placeholder="{{ __('dashboard.end') }}" type="date" name="end" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.countuse') }}</label>
                                        <input class="form-control is-invalid" id="validationTextarea"
                                            placeholder="{{ __('dashboard.countuse') }}" type="number" min="1"
                                            step="1" name="countuse" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.typeOffer') }}</label>
                                        <select name="typeOffer" class="form-select" required aria-label="select example"
                                            onclick="changetype(this)">
                                            <option value="percentage">{{ __('dashboard.percentage') }}</option>
                                        </select>
                                        <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.percentage') }}</label>
                                        <input class="form-control is-invalid"
                                            placeholder="{{ __('dashboard.percentage') }}" type="number" min="0"
                                            step="0.1" max="100" name="percentage" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked">{{ __('dashboard.firstCount') }}</label>
                                            <input class="form-check-input" type="checkbox" name="firstCount"
                                                id="firstCount" onclick='handleClick(this);'>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none;" id="firstCountDiv">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.valueDiscount') }}</label>
                                        <input class="form-control is-invalid" id="firstCountInput"
                                            placeholder="{{ __('dashboard.firstCountInput') }}" type="number"
                                            min="0" step="1" name="firstCountInput">
                                    </div>
                                    
                                    
                                    
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button form="submit-form" type="submit"
                                class="btn btn-primary">{{ __('dashboard.add') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changetype(e) {
            if (e.value == "percentage") {
                document.getElementById('percentageDev').style.display = "block";
                document.getElementById('valueDiscountDev').style.display = "none";
                document.getElementById('percentage').required = true;
                document.getElementById('valueDiscount').required = false;
            } else if (e.value == "valueDiscount") {
                document.getElementById('valueDiscountDev').style.display = "block";
                document.getElementById('percentageDev').style.display = "none";
                document.getElementById('percentage').required = false;
                document.getElementById('valueDiscount').required = true;
            } else {
                document.getElementById('valueDiscountDev').style.display = "none";
                document.getElementById('percentageDev').style.display = "none";
                document.getElementById('percentage').required = false;
                document.getElementById('valueDiscount').required = false;
            }
        }

        function handleClick(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'block';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCountInput').required = true;
                document.getElementById('firstCount').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('categoryid').required = false;
                document.getElementById('resturantid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function handleClickProduct(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('shopData').style.display = 'block';
                document.getElementById('productCheckClick').checked = true;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = true;
                document.getElementById('storeId').required = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function handleClickDiscount(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'block';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('max').required = true;
                document.getElementById('min').required = true;
                document.getElementById('categoryid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('storeId').required = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function handleClick1(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('storeData').style.display = 'block';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = true;
                document.getElementById('max').required = true;
                document.getElementById('min').required = true;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function handleClick2(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'block';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = true;
                document.getElementById('max').required = true;
                document.getElementById('min').required = true;
                document.getElementById('resturantid').required = true;
                document.getElementById('categoryid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }


        function handleClick3(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'block';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('max').required = false;
                document.getElementById('categoryid').required = true;
                document.getElementById('min').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function handleClick4(cb) {
            if (cb.checked) {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = true;
                document.getElementById('max').required = true;
                document.getElementById('min').required = true;
                document.getElementById('resturantid').required = true;
                document.getElementById('categoryid').required = false;
            } else {
                document.getElementById('firstCountDiv').style.display = 'none';
                document.getElementById('storeData').style.display = 'none';
                document.getElementById('categoryData').style.display = 'none';
                document.getElementById('resturantData').style.display = 'none';
                document.getElementById('minandmax').style.display = 'none';
                document.getElementById('shopData').style.display = 'none';
                document.getElementById('firstCountInput').required = false;
                document.getElementById('shopId').required = false;
                document.getElementById('storeId').required = false;
                document.getElementById('productCheckClick').checked = false;
                document.getElementById('handleClickShopsCheck').checked = false;
                document.getElementById('handleClickResturantCheck').checked = false;
                document.getElementById('handleClickCategoryCheck').checked = false;
                document.getElementById('handleClickallCategoryCheck').checked = false;
                document.getElementById('CheckDiscount').checked = false;
                document.getElementById('firstCount').checked = false;
                document.getElementById('max').required = false;
                document.getElementById('min').required = false;
                document.getElementById('resturantid').required = false;
                document.getElementById('categoryid').required = false;
            }
        }

        function getProducts(shopId) {
            let productDiv = document.getElementById("productId")
            let regionId = document.getElementById("shopId")
            productDiv.innerHTML = ""
            shopId = parseInt(shopId.value)
            shopId = isNaN(shopId) ? -1 : shopId
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            if (shopId) {
                $.post("/sliders/getProducts", {
                    "shopId": shopId,
                }, function(data, status, xhr) {
                    data = JSON.parse(data)
                    if (Array.isArray(data)) {
                        document.getElementById("productData").style.display = "block"
                        document.getElementById('productId').required = true;
                        if (productDiv != null) {
                            productDiv.innerHTML +=
                                `<option value="">{{ __('dashboard.openSelect') }}</option>`
                            data.forEach(function(product, i) {
                                productDiv.innerHTML += `
                                    <option value="${product.id}">${product.name}</option>
                                    `
                            })
                        }
                    }
                })
            }

        }
    </script>
@endsection
