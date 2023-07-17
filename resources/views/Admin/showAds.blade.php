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
                            <h1>{{ $ad->name_ar }}</h1>
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
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show"
                                        role="alert">
                                        <span>تفاصيل العنوان</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <div class="table-responsive">
                                        <table id="user-list-table" class="table table-striped" role="grid">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>#</th>
                                                    <th>المفتاح</th>
                                                    <th>{{ __('dashboard.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>العنوان</td>
                                                    <td>{{ $ad->address }}</td>
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

                </div>
                @if($ad->category_id == 3 || $ad->category_id == 4 || $ad->category_id == 5)
                @if(isset($detisls))
                <div class="col-sm-12">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show"
                                        role="alert">
                                        <span>تفاصيل الاعلان</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <div class="table-responsive">
                                        <table id="user-list-table" class="table table-striped" role="grid">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>#</th>
                                                    <th>المفتاح</th>
                                                    <th>{{ __('dashboard.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>هل يوجد تأمين ؟</td>
                                                    <td>
                                                        @if ($detisls->insurance == 1)
                                                            نعم
                                                        @else
                                                            لا
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>هل هو سكن خاص ؟</td>
                                                    <td>
                                                        @if ($detisls->private_house == 1)
                                                            نعم
                                                        @else
                                                            لا
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>هل هو سكن مشترك ؟</td>
                                                    <td>
                                                        @if ($detisls->Shared_accommodation == 1)
                                                            نعم
                                                        @else
                                                            لا
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>هل يسمح بالزيارات ؟</td>
                                                    <td>
                                                        @if ($detisls->visits == 1)
                                                            نعم
                                                        @else
                                                            لا
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>هل يسمح بإصطحاب الحيوانات</td>
                                                    <td>
                                                        @if ($detisls->animals == 1)
                                                            نعم
                                                        @else
                                                            لا
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>عدد غرف النوم</td>
                                                    <td>
                                                        {{ $detisls->bed_room }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>عدد دورات المياه</td>
                                                    <td>
                                                        {{ $detisls->Bathrooms }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>عدد المجالس</td>
                                                    <td>
                                                        {{ $detisls->council }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>هل يوجد طالولة بالمطبخ ؟</td>
                                                    <td>
                                                        @if ($detisls->kitchen_table == 1)
                                                            نعم
                                                        @else
                                                            لا
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
            @endif
                @endif
            
                <div class="col-sm-12">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show"
                                        role="alert">
                                        <span>الشروط و الاحكام</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <div class="table-responsive">
                                        <table id="user-list-table" class="table table-striped" role="grid">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>#</th>
                                                    <th>المفتاح</th>
                                                    <th>{{ __('dashboard.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($terms as $key => $term)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>الشروط و الاحكام</td>
                                                    <td>{{ $term->desc_ar }}</td>
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
                <div class="col-sm-12">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-primary alert-dismissible fade show"
                                        role="alert">
                                        <span>صور الاعلان</span>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    @foreach ($images as $image)
                                        <img height="150px" width="200px" style="margin: 10px 0px 20px 20px"
                                            src="{{ asset('Admin/images/ads/' . $image->image) }}" alt="">
                                    @endforeach
                                </div>
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

            t.push("{{ $ad->name_ar }}");
            x.push({{ $ad->lat }});
            y.push({{ $ad->long }});
            h.push('<p><strong>"{{ $ad->name_ar }}"</strong><br/>"{{ $ad->address }}"</p>');


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
        }



        $(document).ready(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>
