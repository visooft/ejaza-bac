<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Admin/images/logo/' . env('LOGO')) }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/core/libs.min.css') }}" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/hope-ui.min.css') }}?v=1.2.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/custom.min.css') }}?v=1.2.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/dark.min.css') }}" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/customizer.min.css') }}" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/rtl.min.css') }}" />
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <style>
        body,
        head {
            font-family: 'Cairo';
            font-size: 16px;
        }
    </style>

</head>

<body class="" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6 d-md-block d-none p-0 mt-n1 vh-100 overflow-hidden">
                    <img  src="{{ asset('Admin/images/login.png') }}"
                        class="img-fluid" alt="images" height="50%" width="50%" style="margin-top: 200px; margin-right:100px">
                </div>
                <div class="col-md-6 p-0">
                    <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                        <div class="card-body">
                            <a href="#" class="navbar-brand d-flex align-items-center mb-3">
                                <!--Logo start-->
                                <img src="{{ asset('Admin/images/logo/' . env('LOGO')) }}" height="30px" class="svg"
                                    alt="">
                                <!--logo End-->
                                <h4 class="logo-title ms-3">{{ env('APP_NAME') }}</h4>
                            </a>
                            <h2 class="mb-2">إعادة تعيين كلمة المرور</h2>
                            <p>أدخل عنوان بريدك الإلكتروني وسنرسل إليك بريدًا إلكترونيًا يحتوي على إرشادات لإعادة تعيين
                                كلمة المرور الخاصة بك.</p>
                            @include('partials._errors')
                            @include('partials._session')
                            <form method="POST" action="{{ route('reset.password.post') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <label for="email" class="form-label">البريد الالكتروني</label>
                                            <input type="email" class="form-control" id="email"
                                                aria-describedby="email" placeholder=" " name="email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="form-label">كلمة السر</label>
                                            <input type="password" class="form-control" id="password"
                                                aria-describedby="password" name="password" placeholder=" ">
                                            <input type="checkbox" class="form-check-input" id="customCheck1"
                                                onclick="myFunction()">
                                            <label class="form-check-label" for="customCheck1">اظهار كلمة السر</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="form-label">تأكيد كلمة السر</label>
                                            <input type="password" class="form-control" id="passwordConfirm"
                                                aria-describedby="password" name="password_confirmation"
                                                placeholder=" ">
                                            <input type="checkbox" class="form-check-input" id="customCheck1"
                                                onclick="myFunctionConfirm()">
                                            <label class="form-check-label" for="customCheck1">اظهار كلمة السر</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">حفظ التغيير</button>
                            </form>
                        </div>
                    </div>
                    <div class="sign-bg sign-bg-right">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                    transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function myFunctionConfirm() {
            var x = document.getElementById("passwordConfirm");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <!-- Library Bundle Script -->
    <script src="{{ asset('Admin/assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('Admin/assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('Admin/assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('Admin/assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('Admin/assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('Admin/assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('Admin/assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('Admin/assets/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="{{ asset('Admin/assets/js/hope-ui.js') }}" defer></script>
</body>

</html>
