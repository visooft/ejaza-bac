@extends('adminLayout')

@section('main')
    <!-- Nav Header Component Start -->
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1> {{ $user->name }}</h1>
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
    </div> <!-- Nav Header Component End -->
    <!--Nav End-->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-01" class="text-center" data-min-value="0"
                                            data-max-value="100" data-value="90" data-type="percent">
                                            <img width="50px" src="{{ asset('Admin\images\orders.png') }}">
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">{{ __('dashboard.newOrders') }}</p>
                                            <h4 class="counter">{{ $newOrders }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-01" class="text-center" data-min-value="0"
                                            data-max-value="100" data-value="90" data-type="percent">
                                            <img width="50px" src="{{ asset('Admin\images\orders.png') }}">
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">{{ __('dashboard.orderExecuted') }}</p>
                                            <h4 class="counter">{{ $orderExecuted }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if (auth()->user()->role->name != 'merchant')
                                @if ($user->wallet && $user->role_id != 5)
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body">
                                            <a href="{{ route('wallet', $id) }}">
                                                <div class="progress-widget">
                                                    <div id="circle-progress-01" class="text-center" data-min-value="0"
                                                        data-max-value="100" data-value="90" data-type="percent">
                                                        <img width="50px"
                                                            src="{{ asset('Admin\images\wallet-svgrepo-com.svg') }}">
                                                    </div>
                                                    <div class="progress-detail">
                                                        <p class="mb-2">{{ __('dashboard.wallet') }}</p>
                                                        <h4 class="counter">{{ $user->wallet }} {{ __('dashboard.Rial') }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </li>
                                @endif
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                    <div class="card-body">
                                        <a href="{{ route('categoryBuy', $id) }}">
                                            <div class="progress-widget">
                                                <div id="circle-progress-01" class="text-center" data-min-value="0"
                                                    data-max-value="100" data-value="90" data-type="percent">
                                                    <img width="50px" src="{{ asset('Admin\images\orders.png') }}">
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2">{{ __('dashboard.categoryBuy') }}</p>
                                                    <h4 class="counter">{{ $orderExecuted }}</h4>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </li>
                            @endif


                        </ul>
                        <div class="swiper-button swiper-button-next"></div>
                        <div class="swiper-button swiper-button-prev"></div>
                    </div>
                </div>
            </div>
            <div class="card-header d-inline justify-content-center">
                <div class="d-flex mb-4">
                    <div class="d-inline flex-fill justify-content-center flex-wrap">

                        @can('reports')
                            <button onclick="ExportToExcel('xlsx')" type="button" class="btn btn-primary">
                                {{ __('dashboard.reports') }}
                            </button>
                        @endcan
                        @can('reports_seller')
                            <button onclick="ExportToExcel('xlsx')" type="button" class="btn btn-primary">
                                {{ __('dashboard.reports') }}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>{{ __('dashboard.#') }}</th>
                                <th>{{ __('dashboard.orderNumber') }}</th>
                                <th>{{ __('dashboard.clientName') }}</th>
                                <th>{{ __('dashboard.clientEmail') }}</th>
                                <th>{{ __('dashboard.clientPhone') }}</th>
                                <th>{{ __('dashboard.price') }}</th>
                                <th>{{ __('dashboard.delivaryPrice') }}</th>
                                <th>{{ __('dashboard.total') }}</th>
                                <th>{{ __('dashboard.time') }}</th>
                                <th>{{ __('dashboard.date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ route('orderDetials', $order->id) }}">{{ $order->order_id }}</a></td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->user->email }}</td>
                                    <td>{{ $order->user->phone }}</td>
                                    <td>{{ $order->total }} {{ __('dashboard.Rial') }}</td>
                                    <td>{{ $order->delivary }} {{ __('dashboard.Rial') }}</td>
                                    <td>{{ $order->delivary + $order->total }} {{ __('dashboard.Rial') }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>
                                        @if ($order->orderStatus == 'Underway')
                                            {{ __('dashboard.Underway') }}
                                        @elseif($order->orderStatus == 'deliverd')
                                            {{ __('dashboard.deliverd') }}
                                        @elseif($order->orderStatus == 'done')
                                            {{ __('dashboard.done') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex align-items-center list-user-action">
                                            <a class="btn btn-sm btn-icon" style="background-color:#3a57e8"
                                                href="{{ route('orderDetials', $order->id) }}">
                                                <span class="btn-inner">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24">
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
@endsection
<script>
    function hideRow(table) {
        let rowsArray = Array.from(table.rows)

        rowsArray.forEach(function(el, i) {
            el.cells[11].remove(11)

        })
        location.reload(true);

    }

    let mobile = document.querySelector('h1');

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('user-list-table');
        hideRow(elt);

        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });

        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || (`الطلبات.` + (type || 'xlsx')));
    }
</script>
