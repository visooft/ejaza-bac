@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.countOrdersDelivary') }}</h1>
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
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-01"
                                            class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                            data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                                            <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                            </svg>
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">{{ __('dashboard.orderCount') }}</p>
                                            @if (auth()->user()->role->name != 'merchant')
                                                <h4 class="counter">{{ $totalorders }}</h4>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if (auth()->user()->role->name != 'merchant')
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1200">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-06"
                                                class="text-center circle-progress-01 circle-progress circle-progress-info"
                                                data-min-value="0" data-max-value="100" data-value="40" data-type="percent">
                                                <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">{{ __('dashboard.Today') }}</p>
                                                <h4 class="counter"><?= round($total_saleToday / 1000, 2) . 'k' ?>
                                                    {{ __('dashboard.Rial') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1300">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div id="circle-progress-07"
                                                class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                data-min-value="0" data-max-value="100" data-value="30"
                                                data-type="percent">
                                                <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                                </svg>
                                            </div>
                                            <div class="progress-detail">
                                                <p class="mb-2">{{ __('dashboard.deliveryCount') }}</p>
                                                <h4 class="counter">{{ $totalUser }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        <div class="swiper-button swiper-button-next"></div>
                        <div class="swiper-button swiper-button-prev"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="overflow-hidden card" data-aos="fade-up" data-aos-delay="600">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="mb-2 card-title">{{ __('dashboard.bestDelivery') }}</h4>
                                </div>
                                <div class="dropdown">
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-placement="top"
                                        title="bestDelivary" href="#bestDelivary">{{ __('dashboard.reports') }}</a>
                                </div>
                                <div class="dropdown">
                                    <a href="#" class="text-secondary dropdown-toggle" id="dropList"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('dashboard.filter') }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton22">
                                        @foreach ($regions as $region)
                                            <li><a class="dropdown-item"
                                                    onclick="filterData({{ $region->address_id }})">{{ $region->city }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="p-0 card-body">
                                <div class="mt-4 table-responsive">
                                    <table id="clientTable" class="table table-striped" role="grid"
                                        data-toggle="data-table">
                                        <thead>
                                            <tr class="ligth">
                                                <th>{{ __('dashboard.#') }}</th>
                                                <th>{{ __('dashboard.image') }}</th>
                                                <th>{{ __('dashboard.name') }}</th>
                                                <th>{{ __('dashboard.email') }}</th>
                                                <th>{{ __('dashboard.phone') }}</th>
                                                <th>{{ __('dashboard.countOrder') }}</th>
                                                <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usersData as $key => $user)
                                                <tr class="item" aria-valuenow="{{ $key }}">
                                                    <td class="key">{{ $key + 1 }}</td>
                                                    <td class="text-center"><img
                                                            class="image bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ $user->image }}" alt="{{ $user->name }}"></td>
                                                    <td class="name">
                                                        <a href="{{ route('getDeliveryProfile', $user->id) }}">{{ $user->name }}</a></td>
                                                    <td class="email">{{ $user->email }}</td>
                                                    <td class="phone">{{ $user->phone }}</td>
                                                    <td class="count">{{ $user->count }}</td>
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">
                                                            <a class="btn btn-sm btn-icon" style="background-color:#3a57e8"
                                                                href="{{ route('getDeliveryProfile', $user->id) }}">
                                                                <span class="btn-inner">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bestDelivary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.reportDeivary') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submit-form" class="was-validated" action="{{ route('productReport') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.from') }}</label>
                                <input class="form-control is-invalid" id="validationTextarea"
                                    placeholder="{{ __('dashboard.from') }}" type="date" name="from" required>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.to') }}</label>
                                <input class="form-control is-invalid" id="validationTextarea"
                                    placeholder="{{ __('dashboard.to') }}" type="date" name="to" required>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.countDelivery') }}</label>
                                <input class="form-control is-invalid" id="validationTextarea"
                                    placeholder="{{ __('dashboard.countDelivery') }}" type="number" min="0"
                                    step="1" name="countDelivery" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                    <button form="submit-form" type="submit"
                        class="btn btn-primary">{{ __('dashboard.reports') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function getResturantData(e, id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        if (id) {
            $.post("/resturants/getResturantData", {
                "shop_id": id,
            }, function(data, status, xhr) {
                data = JSON.parse(data)
                document.getElementById("time").value = data.time;
                document.getElementById("delivaryCost").value = data.delivaryCost;
                document.getElementById("lat").value = data.lat;
                document.getElementById("long").value = data.long;
                document.getElementById("address").value = data.address;
                document.getElementById("resturantPhone").value = data.phone;
                document.getElementById("link").value = data.link;
            })
        }
    }

    function getUserData(e, id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        if (id) {
            $.post("/notifications/getData", {
                "user_id": id,
            }, function(data, status, xhr) {
                data = JSON.parse(data)
                document.getElementById("id").value = data.id;
                document.getElementById("name").value = data.name;
                document.getElementById("email").value = data.email;
                document.getElementById("phone").value = data.phone;
            })
        }
    }

    function getUserData(e, id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        if (id) {
            $.post("/packages/packageDetials", {
                "id": id,
            }, function(data, status, xhr) {
                data = JSON.parse(data)
                console.log(data);
                document.getElementById("id").value = data.id;
                document.getElementById("name").value = data.address_From;
                document.getElementById("useremail").value = data.address_To;
            })
        }
    }

    function filterData(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        if (e) {
            $.post("/filterClient", {
                "region_id": e,
            }, function(data, status, xhr) {
                data = JSON.parse(data)
                if (data.length > 0) {
                    data.forEach(function(value, i) {
                        var key = document.getElementsByClassName('key');
                        key[i].innerHTML = i + 1;
                        var image = document.getElementsByClassName('image');
                        image[i].src = data[i].image;
                        var name = document.getElementsByClassName('name');
                        name[i].innerHTML = data[i].name;
                        var email = document.getElementsByClassName('email');
                        email[i].innerHTML = data[i].email;
                        var phone = document.getElementsByClassName('phone');
                        phone[i].innerHTML = data[i].phone;
                        var count = document.getElementsByClassName('count');
                        count[i].innerHTML = data[i].count;
                    });
                    document.getElementById("clientTable").deleteRow(data.length + 1);
                }
            })
        }
    }
</script>
