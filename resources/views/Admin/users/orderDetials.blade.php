@extends('adminLayout')
@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
        integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    </head>
@endsection

@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>تفاصيل الحجز #{{ $order->orderNumber }}</h1>
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
            @include('partials._session')
            @include('partials._errors')
            <div class="row">

                <div class="col-sm-12">
                    @if ($order->status == 3)
                        <div class="card">
                            <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                <div class="mb-3 alert alert-left alert-danger alert-dismissible fade show" role="alert">
                                    <span>{{ __('dashboard.orderStatusAlert') }}</span>
                                </div>
                            </div>
                            <div class="card-body px-0">
                                <div class="table-responsive">
                                    <table id="user-list-table" class="table table-striped" role="grid">
                                        <thead>
                                            <tr class="ligth">
                                                <th>{{ __('dashboard.typetype') }}</th>
                                                <th>{{ __('dashboard.valuerequest') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('dashboard.rejecetOrderTest') }}</td>
                                                <td>
                                                    @if (!$order->cancel_en)
                                                        {{ $order->cancel_ar }}
                                                    @else
                                                        @if (app()->getLocale() == 'ar')
                                                            {{ $order->cancel_ar }}
                                                        @else
                                                            {{ $order->cancel_en }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show" role="alert">
                                <span>بيانات الحجز</span>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.address') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                    src="{{ asset('Admin/images/ads/' . $order->image) }}"
                                                    alt="{{ $order->house->name }}">
                                            </td>
                                            <td>{{ $order->house->name_ar }}</td>
                                            <td>{{ $order->house->address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show" role="alert">
                                <span>{{ __('dashboard.userDetials') }}</span>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.email') }}</th>
                                            <th>{{ __('dashboard.phone') }}</th>
                                            <th>{{ __('dashboard.wallet') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->user->email }}</td>
                                            <td>{{ $order->user->phone }}</td>
                                            <td>{{ $order->user->wallet }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show"
                                        role="alert">
                                        <span>المكان</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <div class="table-responsive">
                                        <table id="user-list-table" class="table table-striped" role="grid">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>#</th>
                                                    <th>المكان</th>
                                                    <th>{{ __('dashboard.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>المكان</td>
                                                    <td>{{ $order->house->address }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div id="googleMap" style="width:100%;height:400px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show" role="alert">
                                <span>{{ __('dashboard.typePayment') }}</span>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid">

                                    <tbody>
                                        <tr>
                                            <td>{{ __('dashboard.typePayment') }}</td>
                                            <td>{{ __('dashboard.payment') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                            <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show" role="alert">
                                <span>{{ __('dashboard.typePaymentcheck') }}</span>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.typetype') }}</th>
                                            <th>{{ __('dashboard.value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('dashboard.typePaymenttype') }}</td>
                                            <td>{{ __('dashboard.paymentOnline') }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('dashboard.price') }}</td>
                                            <td>{{ $order->house->price }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                        <tr>
                                            <td>عدد الليالي</td>
                                            <td>{{ $order->count }} ليالي</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('dashboard.total') }}</td>
                                            <td>{{ $order->total }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    {{-- <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            initialize();
        });

        function initialize() {
            var map_options = {
                center: new google.maps.LatLng(23.8859, 45.0792),
                zoom: 7,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var google_map = new google.maps.Map(document.getElementById("googleMap"), map_options);

            var info_window = new google.maps.InfoWindow({
                content: 'loading'
            });

            var t = [];
            var x = [];
            var y = [];
            var h = [];

            var a = [];
            var b = [];
            var c = [];
            var d = [];

            t.push("{{ $order->house->name }}");
            x.push({{ $order->house->lat }});
            y.push({{ $order->house->long }});
            h.push('<p><strong>"{{ $order->house->name }}"</strong><br/>"{{ $order->house->address }}"</p>');


            a.push("{{ $order->user->name }}");
            b.push({{ $order->user->lat }});
            c.push({{ $order->user->long }});
            d.push('<p><strong>"{{ $order->user->name }}"</strong><br/>"{{ $order->user->address }}"</p>');

            var i = 0;
            for (item in t) {
                var m = new google.maps.Marker({
                    map: google_map,
                    animation: google.maps.Animation.DROP,
                    title: t[i],
                    position: new google.maps.LatLng(x[i], y[i]),
                    html: h[i]
                });

                google.maps.event.addListener(m, 'click', function() {
                    info_window.setContent(this.html);
                    info_window.open(google_map, this);
                });
                i++;
            }
            var j = 0;
            for (item in a) {
                var m = new google.maps.Marker({
                    map: google_map,
                    animation: google.maps.Animation.DROP,
                    title: a[j],
                    position: new google.maps.LatLng(b[j], c[j]),
                    html: d[j]
                });

                google.maps.event.addListener(m, 'click', function() {
                    info_window.setContent(this.html);
                    info_window.open(google_map, this);
                });
                j++;
            }
        }



        $(document).ready(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>
