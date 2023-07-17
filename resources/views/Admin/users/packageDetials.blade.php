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
                            <h1>{{ __('dashboard.packageDetials') }} #{{ $package->package_id }}</h1>
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
                @if($package->orderStatus != "deliverd")
                    @if ($package->status == 1 || $package->status == 0)
                        @can('superAdmin')
                            <div class="d-flex mb-4">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalDefault">
                                        {{ __('dashboard.addDelivary') }}
                                    </button>
                                </div>
                            </div>
                        @endcan
                        @if (auth()->user()->role->name == 'Employee')
                            <div class="d-flex mb-4">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalDefault">
                                        {{ __('dashboard.addDelivary') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif

                <div class="col-sm-12">
                    @if ($package->status == 3)
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
                                                    @if (!$package->cancel_en)
                                                        {{ $package->cancel_ar }}
                                                    @else
                                                        @if (app()->getLocale() == 'ar')
                                                            {{ $package->cancel_ar }}
                                                        @else
                                                            {{ $package->cancel_en }}
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

                                            <td>{{ $package->user->name }}</td>
                                            <td>{{ $package->user->email }}</td>
                                            <td>{{ $package->user->phone }}</td>
                                            <td>{{ $package->user->wallet }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($delivary)
                        <div class="card">
                            <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show" role="alert">
                                    <span>{{ __('dashboard.delivaryDetials') }}</span>
                                </div>
                            </div>
                            <div class="card-body px-0">
                                <div class="table-responsive">
                                    <table id="user-list-table" class="table table-striped" role="grid">
                                        <thead>
                                            <tr class="ligth">
                                                <th>{{ __('dashboard.image') }}</th>
                                                <th>{{ __('dashboard.name') }}</th>
                                                <th>{{ __('dashboard.email') }}</th>
                                                <th>{{ __('dashboard.phone') }}</th>
                                                <th>{{ __('dashboard.address') }}</th>
                                                <th>{{ __('dashboard.wallet') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    @if ($delivary->image)
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ asset('Admin/images/deliveries/' . $delivary->image) }}"
                                                            alt="{{ $delivary->name }}">
                                                    @else
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ asset('Admin/assets/images/avatars/01.png') }}"
                                                            alt="{{ $delivary->name }}">
                                                    @endif

                                                </td>
                                                <td>{{ $delivary->name }}</td>
                                                <td>{{ $delivary->email }}</td>
                                                <td>{{ $delivary->phone }}</td>
                                                <td>{{ $delivary->address }}</td>
                                                <td>{{ $delivary->wallet }} {{ __('dashboard.Rial') }}</td>
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
                                <span>{{ __('dashboard.orderDetials') }}</span>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid"
                                    data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.orderNumber') }}</th>
                                            <th>{{ __('dashboard.clientName') }}</th>
                                            <th>{{ __('dashboard.clientEmail') }}</th>
                                            <th>{{ __('dashboard.clientPhone') }}</th>
                                            <th>{{ __('dashboard.package_type') }}</th>
                                            <th>{{ __('dashboard.time') }}</th>
                                            <th>{{ __('dashboard.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a onclick="getUserData(this, '{{ $package->id }}')" href="#packageModel"
                                                    data-bs-toggle="modal" data-placement="top" title="package"
                                                    data-original-title="package">{{ $package->package_id }}</a>
                                            </td>
                                            <td>{{ $package->user->name }}</td>
                                            <td>{{ $package->user->email }}</td>
                                            <td>{{ $package->user->phone }}</td>
                                            <td>{{ $package->package_type }}</td>
                                            <td>{{ $package->created_at }}</td>
                                            <td>{{ $package->date }}</td>
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
                                        <span>{{ __('dashboard.locationDelivary') }}</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <div class="table-responsive">
                                        <table id="user-list-table" class="table table-striped" role="grid">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>#</th>
                                                    <th>{{ __('dashboard.location') }}</th>
                                                    <th>{{ __('dashboard.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ __('dashboard.locationGo') }}</td>
                                                    <td>{{ $package->address_To }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>{{ __('dashboard.locationreturn') }}</td>
                                                    <td>{{ $package->address_From }}</td>
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
                                            <td>{{ __('dashboard.managerValue') }}</td>
                                            <td>{{ $package->application_ratio }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td>{{ __('dashboard.price') }}</td>
                                            <td>{{ $package->total }} {{ __('dashboard.Rial') }}</td>
                                        </tr> --}}
                                        {{-- <tr>
                                            <td>{{ __('dashboard.Value_Added') }}</td>
                                            <td>{{ $Value_Added }} {{ __('dashboard.Rial') }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td>{{ __('dashboard.delivaryPrice') }}</td>
                                            <td>{{ $package->delegate_ratio }} {{ __('dashboard.Rial') }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('dashboard.total') }}</td>
                                            <td>{{ $package->total }} {{ __('dashboard.Rial') }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('dashboard.imageInvoice') }}</td>
                                            <td style="height:200px">
                                                @if ($package->invoiveImage)
                                                    <a href="{{ asset('Admin/images/orders/' . $package->invoiveImage) }}"
                                                        download><img style="height:200px"
                                                            src="{{ asset('Admin/images/orders/' . $package->invoiveImage) }}"
                                                            alt="{{ $package->user->name }}"></a>
                                                @else
                                                    {{ __('dashboard.noImage') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.addDelivary') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="submit-form" class="was-validated" action="{{ route('addDelivarypackage') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" value="{{ $package->id }}" name="package_id" />
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.delivary') }}</label>
                                    <select name="delivary_id" class="form-select" required aria-label="select example"
                                        id="select-state" placeholder="{{ __('dashboard.deliverySearch') }}">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($delivaresData as $delivary)
                                            <option value="{{ $delivary->id }}">{{ $delivary->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="submit-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.add') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="packageModel" tabindex="-1" aria-labelledby="packageModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="packageModel">{{ __('dashboard.packageDetial') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.#') }}</label>
                                <input class="form-control" id="id" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.address_From') }}</label>
                                <input class="form-control" id="name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.address_To') }}</label>
                                <input class="form-control" id="useremail" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
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

            t.push("{{ $package->user->name }}");
            x.push({{ $package->lat_From }});
            y.push({{ $package->long_From }});
            h.push('<p><strong>"{{ $package->user->name }}"</strong><br/>"{{ $package->address_From }}"</p>');


            a.push("{{ $package->user->name }}");
            b.push({{ $package->lat_To }});
            c.push({{ $package->long_To }});
            d.push('<p><strong>"{{ $package->user->name }}"</strong><br/>"{{ $package->address_To }}"</p>');

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
    </script>
