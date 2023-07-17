<!doctype html>
<html lang="en" @if (app()->getLocale() == 'ar') dir="rtl"
    @else
        dir="ltr" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <title>{{ env('APP_NAME') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Admin/images/logo/' . env('LOGO')) }}" />


    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/core/libs.min.css') }}" />

    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/aos/dist/aos.css') }}" />

    <!-- {{ env('APP_NAME') }} Design System Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/hope-ui.min.css') }}?v=1.2.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/custom.min.css') }}?v=1.2.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/dark.min.css') }}" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/customizer.min.css') }}" />
    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/rtl.min.css') }}" />
    {{-- font --}}
    <livewire:styles />
    @yield('head')

    @yield('cs')
    <style>
        body,
        head {
            font-family: 'Cairo';
            font-size: 16px;
        }
        .checked {
            color: orange;
        }
        .rcorners {
            border-radius: 25px;
            background: #3a57e8;
            padding: 5px;
            color: white
        }
    </style>
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <aside class="sidebar sidebar-default navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ route('admin') }}" class="navbar-brand">
                <!--Logo start-->

                <img width="20px" height="20px" src="{{ asset('Admin/images/logo/' . env('LOGO')) }}"
                    alt="">
                <!--logo End-->
                <h4 class="logo-title">{{ env('APP_NAME') }}</h4>

            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">{{ __('dashboard.dashboard') }}</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin') }}">
                            <i class="icon">
                                <svg width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">{{ __('dashboard.dashboard') }}</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">{{ __('dashboard.Members') }}</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @can('superAdmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('superAdmin') }}">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.Admin') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('embloyee')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('embloyee') }}">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.embloyee') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('users')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users') }}">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.users') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('roles')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles') }}">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M2 11.0786C2.05 13.4166 2.19 17.4156 2.21 17.8566C2.281 18.7996 2.642 19.7526 3.204 20.4246C3.986 21.3676 4.949 21.7886 6.292 21.7886C8.148 21.7986 10.194 21.7986 12.181 21.7986C14.176 21.7986 16.112 21.7986 17.747 21.7886C19.071 21.7886 20.064 21.3566 20.836 20.4246C21.398 19.7526 21.759 18.7896 21.81 17.8566C21.83 17.4856 21.93 13.1446 21.99 11.0786H2Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M11.2451 15.3843V16.6783C11.2451 17.0923 11.5811 17.4283 11.9951 17.4283C12.4091 17.4283 12.7451 17.0923 12.7451 16.6783V15.3843C12.7451 14.9703 12.4091 14.6343 11.9951 14.6343C11.5811 14.6343 11.2451 14.9703 11.2451 15.3843Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.211 14.5565C10.111 14.9195 9.762 15.1515 9.384 15.1015C6.833 14.7455 4.395 13.8405 2.337 12.4815C2.126 12.3435 2 12.1075 2 11.8555V8.38949C2 6.28949 3.712 4.58149 5.817 4.58149H7.784C7.972 3.12949 9.202 2.00049 10.704 2.00049H13.286C14.787 2.00049 16.018 3.12949 16.206 4.58149H18.183C20.282 4.58149 21.99 6.28949 21.99 8.38949V11.8555C21.99 12.1075 21.863 12.3425 21.654 12.4815C19.592 13.8465 17.144 14.7555 14.576 15.1105C14.541 15.1155 14.507 15.1175 14.473 15.1175C14.134 15.1175 13.831 14.8885 13.746 14.5525C13.544 13.7565 12.821 13.1995 11.99 13.1995C11.148 13.1995 10.433 13.7445 10.211 14.5565ZM13.286 3.50049H10.704C10.031 3.50049 9.469 3.96049 9.301 4.58149H14.688C14.52 3.96049 13.958 3.50049 13.286 3.50049Z"
                                            fill="currentColor">
                                        </path>
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.Roles') }}</span>
                            </a>
                        </li>
                    @endcan


                    @can('notifications')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notifications') }}">
                                <i class="icon">
                                    <svg width="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.7695 11.6453C19.039 10.7923 18.7071 10.0531 18.7071 8.79716V8.37013C18.7071 6.73354 18.3304 5.67907 17.5115 4.62459C16.2493 2.98699 14.1244 2 12.0442 2H11.9558C9.91935 2 7.86106 2.94167 6.577 4.5128C5.71333 5.58842 5.29293 6.68822 5.29293 8.37013V8.79716C5.29293 10.0531 4.98284 10.7923 4.23049 11.6453C3.67691 12.2738 3.5 13.0815 3.5 13.9557C3.5 14.8309 3.78723 15.6598 4.36367 16.3336C5.11602 17.1413 6.17846 17.6569 7.26375 17.7466C8.83505 17.9258 10.4063 17.9933 12.0005 17.9933C13.5937 17.9933 15.165 17.8805 16.7372 17.7466C17.8215 17.6569 18.884 17.1413 19.6363 16.3336C20.2118 15.6598 20.5 14.8309 20.5 13.9557C20.5 13.0815 20.3231 12.2738 19.7695 11.6453Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M14.0088 19.2283C13.5088 19.1215 10.4627 19.1215 9.96275 19.2283C9.53539 19.327 9.07324 19.5566 9.07324 20.0602C9.09809 20.5406 9.37935 20.9646 9.76895 21.2335L9.76795 21.2345C10.2718 21.6273 10.8632 21.877 11.4824 21.9667C11.8123 22.012 12.1482 22.01 12.4901 21.9667C13.1083 21.877 13.6997 21.6273 14.2036 21.2345L14.2026 21.2335C14.5922 20.9646 14.8734 20.5406 14.8983 20.0602C14.8983 19.5566 14.4361 19.327 14.0088 19.2283Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.notifications') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('settings')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('settings') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACbklEQVR4nO2ZsWsUQRSHvwhGSBGwEAI2akC0EysFsbIQLlFBO8EuELRJZyWKMailARPxD7DRynTCJSltFCSkSJtAsFGSbCw0eiMDrxiXmZ3Zu7mdPdkfPDi4N7+Z73Zmdt4cNGrUqFtdB1aBfUAljn1gBZgsC/GsBoNXjpgr8yRUzWMiBGS1BgNVnlgOAclqMFDlib0QEDUg4VXMzm4Zvg8HGeSU4XtjUEG+A0OG74m6ghwAC8CPwJ1FQ+04cteBFylADoz5Py5v3XzOA4v3m1zOL2AWOCLf368a5LHl154GvgLPZRq5dBJ4CXwEzlm+/1AlyBYwaml7iN50CfhT9Rp5RVzp6bWeYrF3gCsRQcoeVKOB6PgcCeKoLHyVCuRRgY8+oballsjkc6sg/30qkN/AMYfHk4J2eru16WrVIHoKfAGeFjwJn4ftyRwGXgOfgJ/9BLkj+/6wp/1ywCD0NCvSMHAemOoHSKiyWPWEKBnIXgDIbkqQGeCy441uqh1hao1KXzP9XOz6CLEBLDrat7pc7FqL4h1yTOkZxIzTDo/ZLrbfMyX7jgqiT7EutWQKZYEvRP00koFs5qrAbjUkXioVyE3i6VoqkLfE17uqQb4BYz0WVrbcMfGuDERfOuR1G9iWDUDvQC6dlfbb0iavhSpBOnIO0joOLFly5i3e85a8JfHQmhLvStdIR8pd1xXPmsV7zZG7I16dFIs9pF4ZMXxH5Boplr9XKmJcMHwvRvb2KmZndw3fe4MMovoY/8UfPbt+DPs9bt2iHQIyWYOBKk8UnaL/0VwNBqtK1jNOTciNSB3WTBZQzzRq1Ai3/gK+6C+OngQFugAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">{{ __('dashboard.settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    {{-- @can('financial_reports')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-reports" role="button"
                                aria-expanded="false" aria-controls="sidebar-user">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAABECAYAAAA4E5OyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAGNUlEQVR4nO1ba2wVRRT+ChWsD2IVK1owtRjFYGsVpGpUBIvvRBHUBh/xgQ+sj8RGI0RjfSQaqyJWo2hAg4jGWB9BYgTURoJB0QiIUX741tJqFQUEKdZrTvJtMpnMvXt27969e9v7JSfQ2Z2Zne/OnDnnzBmgiCKywX4ATgLQkFCZCKAKMWAsgDcB9AJIFYBsAHBRrsiYBmAHOxJC1gBYkVDpANBjEPMsgEFRknECgH/Y+HMAhiP5KAVwHYDt/O77omx8LRt9DIWHSQD+BbALwOgoGjyGZHQBKENh4nmO4d4oGruBjS10PDsAwFWcmhqpR7TYC0C1IfI9LpzHMSyPotO7M6zBtoBafyeAwYgO6632RdlXOt6r5XN5P2u0sDH518axAJ4BMF8ptyBadDlIl8HbOJrPvsg1IfnGgCNkJIAPAXxqiCzhAUvIWY4Bf248LxKChBNyM40e7S6zLqAJXXAzpAnA7gCEfAagxGH4PQjgIYr0U1GohESBlxyDunEgE/KKY1CevVIkBEVC0K9myDgAiwG8aonohZMHIiFtGXaURcr25znqemG/4wD0Wc/eMequczh3h+STkHIA0zkAWw5Uti92yWGGC297qxWWiz/EeFamdP8LapeJA0VCkkLI3gBmAmhnMOZLAO8CuCPN2u7XhEwF0JlByf4NYI7DdPcLEZYHkLKkENIE4L80RFwD4GVjt1isJGWaY4fxE/GrJuebkEk+Hq8EeQSnAfiDZbMV/Z4JoJt1tNKZJpAdGyElDlsgHSEeKX08PDoY8SE2QuoV09gkxLRMm9EPCZkTgpALWL5M0XelZXj5yYh8E/KUgpBzrTpjlGckVwRUqCkqdru/WAmZq/hIOSRvNOqMZ7lE0DPhFABfAfgmgGxkBC6vMdWUQkSR3sY617NMtuK4EBsh1RnsD5fMpfsu/5+B+BCrHdIeYq3L9B7q069s6TWMubhEdFEiCakC8FtAa3KKol9vaWUSOdVPhyNpQbcCWMr3exh8msCEmpyZ7icqSZGklSuV/YryXW0dY5rS4UiA2ZN6bZPiWzZzTAflghBvpryWQaesYWpWriDb7U8hlu+fAK4N4nS2KAnxINGvWUy/egLA7QwF5golPOgKotxd8rpCrxVExKwtSyJMWc6QQ2yE1AO4ibMoCsxWDlRIu1X5rit1LCeENBjxjS0ReLs1VNKaNK46APuwXw0pM+IgZL7V6WVZtrdKMbB2KxIvy+FRRb0fM+mTlggIudgRROpOc6ikwQTFoNYywU+SjO8H8AiAw1l/kaK+ZF/mhJBzjNz4x2kYreDfvwM4PkSbCxUDauSZj+cqpHjSV86cfb/6q3NByEQjP/5ho1ym41ss/yvAsaeH7xUDEr0xylE+nf37xWtlRu8fJSHjOdgU9Ydt+OxhRM+2U+lqMFKpGM/nKd9mhx/1trKNs6MiZKxxG2FJhjSqwUba9U4f38QzzVdaH72Ky/Jpq/wN1pEl+Z7PEckytrHEKr86CkJGA/iFdZZyJmSCzJwn+X5vhvstQ9L8sl6UfRDNcPPZXdaPUUvjy26jytiFTIv3zmwJqQTwLd//IMBlgRLqGG/tSvjQRCn9JO+5ORgv8FSXRi+sZ+6a2Bb7sq33rXcuZRtTrPKmbAgZzqNLefdjdh4U97B+n7HtyS/8Isvl7OVyx6A3Gfd5/G5YDaV3bpZLf187EginhiFkHF3xbiMIky4tQYNmTluRBVzf0u5WLo8y5RU3Ofm7xFF+BpexJp20JgwhG40GdkR0ADXLmv5CwKnG8w7FYCZTJ9jmfR1ns1/9H9KFBFp8CPEUqMjPiA7mdimzw0STYkCSmQTGOrZyST3AspmK+hK6QBhCGgFso8gUjQqtxsfJlmpimMJR62WOmqeHvN1OlsGvirpHhLlA5KE0mxilj6V7epqp26z4lXdTD1WQkFbOFr96cgAX6opZPiE/wEeKwXlWa7Xy3e/8NoXaBF9CHKWMo25RvrdN64F/Yhw0JQ1jlM6en/QwXUOFesPwWRAg5TIujHD4OEFkQ5g7vRcyTyypV91XKq1VU7po84TeEI5iuF4Ty0yCdNKL9v7eRaX5As3yyHTiMPoDDQkV0QWHGt9bHuaErogioMb/W7Z0gAP5vfUAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">{{ __('dashboard.financial_reports') }}</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebar-reports" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrders') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> U </i>
                                        <span class="item-name">{{ __('dashboard.countOrders') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrdersClient') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">{{ __('dashboard.countOrdersClient') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrdersResturant') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">{{ __('dashboard.countOrdersResturant') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrdersStore') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">{{ __('dashboard.countOrdersStore') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrdersDelivary') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">{{ __('dashboard.countOrdersDelivary') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('countOrdersCacher') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8"
                                                        fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">{{ __('dashboard.countOrdersCacher') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan --}}

                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">{{ __('dashboard.Pages') }}</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>

                    @can('sliders')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sliders') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.sliders') }}</span>
                            </a>
                        </li>
                    
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Adspace') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                                    </svg>
                                </i>
                                <span class="item-name">مساحة اعلانية</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('splach') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                                    </svg>
                                </i>
                                <span class="item-name">splach</span>
                            </a>
                        </li>
                    @endcan
                    @can('country')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('country') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z" />
                                    </svg>

                                </i>
                                <span class="item-name">الدول</span>
                            </a>
                        </li>
                    @endcan
                    @can('category')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-hdd-rack-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1v2H2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2h-1V7h1a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm.5 3a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm-2 7a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zM12 7v2H4V7h8z" />
                                    </svg>
                                </i>
                                <span class="item-name">{{ __('dashboard.category') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('offers')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('offers') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFRUlEQVR4nO1aW4gcRRTt2VURn6DEdXdn7rl1b082jhgJi6j4WFHRD0VQ0aAJik8UJIIo+RDRD9Gg/ogRIpooiIoiPiK+8PXh40ejGHwb8MOIT/DPL1G5PT2btjO721093TNL+kBBV01P1e1TdW/de6uCoEaNGjVq1KgxDLSJZCWRC/ZBjAvxnUr41Yo9W1uwr0CA5xT8DoCjrdiztQX7CgCsSs34eNy2bDAWklsvxBtHoZgsQRA0Kvv6kNx6BXYqsGlEyk5HtK4yAhS4y0owIqhcHq0JQGHGw+mwKUSnKHCyc25iWU2I+g84LsANAv5SCb8o+AMh/kjAfyjwsTKvrVgeP/gMuGpq6kgF3o/2/JacmrLa48p8roI/EcJLk5OTB5UtTyFozgEBHCjEnwrxPYttV7Ozs/sr8eNCeMO22rLkKQzNOaAS36vET6c/NgTWhESduSDYL/HTmBC/J8QbypKnMDTHgCJyuOn4TKs11WtrM5+uxD8I8WcC/kIJ3yrR7Px/mnKcgHcbSYOWp3oCgAuV+NVe3Sy+GUAhOivxzkUC/NhZ0TlkTxvvsB1i0PIUQkjUyTugA642ve7VFbhdCVvS7wmwPbkLCPCokrs2yxhJeXoylhK+Cnh3N3rLTkD0fhT28q1K7iYh/GZLfK+PIDwhwI29ugAP2ftZxujJY2OZjAMNr8MwXGFW2QwTEU0mB8zcB7BGgCeV+BnXcqf1GeMwI4mZj++12XboiC7OvQL6yOuNMBJ8b0YHpHNjzrnVSnxd5BgBDya3TSX+M6uH2EeecasL+Cf7Bm8JNeqY/7GIa5AEdDqdAxR4SwnfCPBsSO6S1Li3CPGL+eT8nzwNC5MV/HehiVJjkfjhoiqQRkh0jQKv9HN2XNOdIMDvzDyTR86UCrxp8irwSGECtNtBl1Hin81l9e5wT7/3CfFt6XYBLjMj6cid79nvGaayvRVbWFU11UF6AN9+BbjfdoVkv0r43ByjpEOUA30naOAEDMrKpgmwuhA/4JPWSi75pLdZGgExCqlEPwKS9axYakWWSUAhlRDiO4T47l5dibdm9fryTEDpBPiqhLZax1o8YLuBRX32nF6+Pkt+KAT4qoQFOrF3uNUIyfifXCuuSgJ8BGxE+YCup7aU8fOyOZUTkFaJhZaoJUCE+HUh/kqJv1bi11JJEa8lPxIEZJkxc3jMFY49wTEFv90vIVrU7xgmAYt+gLT4Zgt35+vgzakU2EA8z6ETsJBK2J2A+Fh8g5FhzwC46JIfSQIMIfOcgv+y8FSIzrQ2C4Ut62PFnq3N0mT2jr1r/wkKYiQIENP3aLbpvEV0en7Jh8znOHJnR3lD4KrlTECjm5TA923gmIVUIrnkk46UNjWMdohuomRsCPIH3h1YdleAl+0UqNlsHuF7Rcb+G98e2T4zM3NoVfIX6oCZYaGtZX6XyutnuSTVPS3CFuvT+h5pAkLgpDiHuNF70IVkIb4+thFzI0mAMq+15eybzckCM5CRcWS+cpQIaMQZ2F1lHUokIdPStmRqFuNYOgGrJyYOVuIXonN+kaOCimDGUYjftSM3O1MYCgHtZnM6Os8HP2Zp7qBiRAEVePNixrE0AtrMJ5Zl7HyNY78Tp1II0BZfGu3fLb4gGBFEt0u6Ml1RJgGN6GIieFfWDE6VcM6tjI3jpp5xHBgB6J7VPSXgD6s0dnlh95C6J0L8fGSgB0GARBEb71DibcMwdl7njsTbTObojkERAhzROgX/q4Tvhn0fOG8xmU12i0aLENoQ4PIRuAvsVeKPr+4SdY0aNWrUqBEsK/wH0jORQSw5AWsAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">{{ __('dashboard.offers') }}</span>
                            </a>
                        </li>
                    @endcan --}}

                    @can('ads')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-Ads" role="button"
                                aria-expanded="false" aria-controls="utilities-Ads">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">بيوت العطلات</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:resturantssidebar />
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-partiner" role="button"
                                aria-expanded="false" aria-controls="utilities-partiner">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">سكن مشترك</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:partinersidebar />
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-camp" role="button"
                                aria-expanded="false" aria-controls="utilities-camp">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">مخيمات وشاليهات</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:campsidebar />
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-travel" role="button"
                                aria-expanded="false" aria-controls="utilities-travel">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">جروبات السفر</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:travel/>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-events" role="button"
                                aria-expanded="false" aria-controls="utilities-events">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">الفعاليات</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:event/>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-gide" role="button"
                                aria-expanded="false" aria-controls="utilities-gide">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">ارشاد سياحي</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:guide/>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-market" role="button"
                                aria-expanded="false" aria-controls="utilities-market">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3UsUoDQRDG8V8VFERbLcRGCFjGJxB8BQsbbcTW0lfwFQRtbBQRLHyFpBOCpa1YKEEhQhojrBxsYAnneRcvIOIHA8sw3/x3ZmEppwa20MYt9jGrBi3hEI8IY/GMI6xM0ngDVxgmDbvYi9FN8sNYm3kKNYMd3CXmD9xgM6d+HWd4T+rvcYC5tHA1jvqSFD7F3HKJaRfjGh8Sfx/HWDM2bgfb8VGrqhG9nbG12sUpWupTK/bMeudqdIOic6Y3XKOposoCQozXku81MSDgctqA/rQBoQpgEA3NxDw6D+oAXOSYQ4zzOgALOEEvMfdibr4OQKpQYP47gPYXP25tgB8p/AO+0+9e0ScTnqgZ+mptQgAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">تسوق و مطاعم</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:market/>
                        </li>
                    @endcan

                    @can('orders')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utilities-order" role="button"
                                aria-expanded="false" aria-controls="utilities-order">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAACrklEQVR4nO2aO2gUQRiAPzQQBYliEUx8gBofhRaaRtFaFAsRtRCLCKIQK61MoSLBR+OCNoKolSD4QFKJsRQMKiIiGNFGQbhCESEGLCQXGfgPl2V3c3s3Mze7/B/8ze3s3s13s/P4Z0BRFEVRFKV9uoB+YE2LsQropoSVPg5MADPArIX4CJwHegicFcAbS5VOixqwjUDpAT44rHwjfgObCZDbHirfiHfAPAJiGfDXowATewmIIc+VN3GDgBjtgIBxAiLK+aGmbzBcL1C5V3LPsZwyZpgthYBIymwC/jQp4Ijcc6hKAhoSrgEPMuIWsIv/VE5AUVQA2gLQVwDtA6hsJ7g0tvZfGdr83qWA1cDLlLJmnnBXkiiVFvBsjonQV6CXCguYamI2aCSdsRSHJVMVjIDnLSx+2o2bIQnYAEx6FvA+JAGG+cBGYFCSG64FjBH4WqDmWMCF0AWMOxZwIHQBVx0LGAhdwJDDyv9yPcuMLAjYUtYh0JaAbkep9ZqsM0qREZq0XPknwDo8EFkScD9jF2iwYJjXaTEeiSwJOJty/09gAYETWRKwz1LTn5EtdadjvwsBvRbPFMxKp7qVkqXFH1ruCEcomYA+4ItFASa1XrqNkT7gkYXX4bGvPGOU8yPMVlg75w72yL9YNMxQ6I3LOQKm5NxQM3GUknLSwrv6PXEKzDTd08Br2S4/NUdzNpnmezKbHPN9jmjAgoA7iWdeSSlzKeP7lwDfEmWngbV45GmbAoYT6bLpjBNi5lqS4YxnXvRYf9bLurtVASdiz1oE1FPK1OVaknOdWgYn2Qn8aFGAOQkaZyKlzAvS2Z4h7CAdoF9OeqQ14bx4m3iOyRh/jl3/JJ9lMRLLJ9TlTFJHWSj/zP4CY3dXSpJkh0Qzh6aXA7tlRFAURVEURVEUivEPCT0XVLNiQc8AAAAASUVORK5CYII=">

                                </i>
                                <span class="item-name">{{ __('dashboard.orders') }}</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <livewire:order-side-bar />
                        </li>
                    @endcan
                    @can('wheel_of_fortunes')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wheel_of_fortunes') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAA/UlEQVRoge2ZSw6CQBAFSw/i5zB6RD8X8QKGgxA3utSVutEFsBJMK226ia+SDgkZmFeB9IQBxH8wA7bAAbjXx019fjAsgQvwaKkLsIiLZmdOt0RTZ2AaFdDKlvcSTa2jAlo5YBMpowJauWETuXpPPHa+38k47ug8r7vIznlcGDNsXWsSFfATFlRhuyQGsY40TKlabEnVAEpgxUCehBBOFNgWv7bae4cZ9bj2ETj3C94LYhgSyYZEstFHpHBL4YBrC6yxtmW13zYkkg2JZEMi2ZBINiSSDYlkQyLZ6Pth1bZnZcV1vytyX6uLrzLp1cqGRLIhEX6zr+X+u0FE8QTfkmzpYlQL+QAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">عجلة الحظ</span>
                            </a>
                        </li>
                    @endcan
                    @can('offers')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('offers') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAA/UlEQVRoge2ZSw6CQBAFSw/i5zB6RD8X8QKGgxA3utSVutEFsBJMK226ia+SDgkZmFeB9IQBxH8wA7bAAbjXx019fjAsgQvwaKkLsIiLZmdOt0RTZ2AaFdDKlvcSTa2jAlo5YBMpowJauWETuXpPPHa+38k47ug8r7vIznlcGDNsXWsSFfATFlRhuyQGsY40TKlabEnVAEpgxUCehBBOFNgWv7bae4cZ9bj2ETj3C94LYhgSyYZEstFHpHBL4YBrC6yxtmW13zYkkg2JZEMi2ZBINiSSDYlkQyLZ6Pth1bZnZcV1vytyX6uLrzLp1cqGRLIhEX6zr+X+u0FE8QTfkmzpYlQL+QAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">العروض</span>
                            </a>
                        </li>
                    @endcan
                    @can('coupon')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('coupon') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACaklEQVR4nO2YTWsUMRiAH2tFUOtHq9CTrScRwXq3liIU9FLQs+LFo6BnT/pbxIPiRQUtYm1V8AO1tYXqXxAPirZityiRyBt9DTu7GbuZCW4eCOzO7EzeZ5M3X5DJZLqKIeAa8AlYBm4BBzrw3h7gLPAI+AIYVRaBPXSQYeC9V4ktn4HRdbx3C3CnyXujSFhuqAruScv8kO/L/yizFXhYpYRlRSqY4g9nlIztEgcpJzFTILEQS8LyTSqx3UBz3mupELZJPhRJ7CYid1VlF9X1Her6KrAxQOJxXRKWQ6p72XIJ2CxSOphWgfQBT+qUcByVxDYtyjwwQPOcmC145k2VEo5jwNc2Mq+B/t9PwHbgaUoSjhHgPtAoCG4NOK5y6FmKEpoNMkwuehKn5P5O4EXqEhonY1vopGqJ5wESl717DhP5ekuZCfm8C3gprbPWYjDwJZIQcfRLsjdkkTmsZIpGtCowZUSsxJw80BCJfSJSp0QpkQEJ1h+9fImJmOuo9WJz4lXABHlCljHvgEESolf+3YUCiTklMenNO9GW6WW61mHgQZMRyZdws/tYweRZpYzxRUKWKFrC7QKnC35blYzRIr7ESsA6KxUZ40RGvMCvyKHBEbVLNG2WHXXL/GJKVXqBv/ngbazGSVhmVSqzSa45rQKxu0hkL05iMsZ1LbehWgI2yc1zwHfv8GE8cAatWsa4uK6rL2+9Yxx9HORORgiUuV2RjHFxDQUe0JVdZfbIsdKsvCuWjNFx7QWuSnJ/BG4C+ztUUSYWpTcwqcZlskhcTNe2SCY1TKJNaLo2R4xXUr3elv9GJJPJZKidn1Je1wPZ1yKbAAAAAElFTkSuQmCC">
                                </i>
                                <span class="item-name">{{ __('dashboard.coupon') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('info')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('info') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAA/UlEQVRoge2ZSw6CQBAFSw/i5zB6RD8X8QKGgxA3utSVutEFsBJMK226ia+SDgkZmFeB9IQBxH8wA7bAAbjXx019fjAsgQvwaKkLsIiLZmdOt0RTZ2AaFdDKlvcSTa2jAlo5YBMpowJauWETuXpPPHa+38k47ug8r7vIznlcGDNsXWsSFfATFlRhuyQGsY40TKlabEnVAEpgxUCehBBOFNgWv7bae4cZ9bj2ETj3C94LYhgSyYZEstFHpHBL4YBrC6yxtmW13zYkkg2JZEMi2ZBINiSSDYlkQyLZ6Pth1bZnZcV1vytyX6uLrzLp1cqGRLIhEX6zr+X+u0FE8QTfkmzpYlQL+QAAAABJRU5ErkJggg==">
                                </i>
                                <span class="item-name">{{ __('dashboard.info') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('about')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAACDElEQVRIie3WTYhOURgH8F/mwyjiNTWRUCym1JSSzcyoWVpYyYLSxFKRsPS1EPZWIxZKPhbE1oKiLKhJWEjJJDWSbwv56r0W99y67pz33vvOm2zmX6enzvN//v/znuecc1/m8J9xBF/wAmfQaKN2La7jLd7haFVBP67iK5LCeIDeGqYrglmx/jXWtSq6EinIj101jCdK6m/mifNCbGBriWCC+TWM15TkhmOTIyUrTXA48LqxH5P4hjfYl9Ppw60WGt9jxttKTJ+iCz0loq+wJ2gNSA9mkfMsZry9xPhg4Oyt2JUEo4F7PpJ7njfMetwVW03Aw9yuVGFniPcjud8x47Kr8j7EZTWMV4Y4HcmNx4wHaoi9rGGccZYW5u9JD+QM4w0lYiMhXqphfLeF3o4isTvEcekFH8NybMlx+kOss9WrQvxVmI9t/Qz0+Ps0Zv0fDYKtTvQPrA/cy4XcjF9cRC/OForOSR8GOF1ifCpwluBTIdfENWwqGvbhgPQxj4lm/W1gKpKfCoZVi0twUWjxaunlLiM3sTkID0bygyE3hp8VWgkOwY0axGZoQYZiPsOFGloJHsGHCtJtbMyJD0U4Q7n8MO5UaH7WBvqk3+TpiNA0dmNBO4JVWIgT0qezags/4iQWdWq6WPrU1elbfkyG2lnj+CxMs3GsE+MnHRg/7sQ49k+i7mjr5M7hn+EPzTE23N4QdMkAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">{{ __('dashboard.about') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('terms') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAACDElEQVRIie3WTYhOURgH8F/mwyjiNTWRUCym1JSSzcyoWVpYyYLSxFKRsPS1EPZWIxZKPhbE1oKiLKhJWEjJJDWSbwv56r0W99y67pz33vvOm2zmX6enzvN//v/znuecc1/m8J9xBF/wAmfQaKN2La7jLd7haFVBP67iK5LCeIDeGqYrglmx/jXWtSq6EinIj101jCdK6m/mifNCbGBriWCC+TWM15TkhmOTIyUrTXA48LqxH5P4hjfYl9Ppw60WGt9jxttKTJ+iCz0loq+wJ2gNSA9mkfMsZry9xPhg4Oyt2JUEo4F7PpJ7njfMetwVW03Aw9yuVGFniPcjud8x47Kr8j7EZTWMV4Y4HcmNx4wHaoi9rGGccZYW5u9JD+QM4w0lYiMhXqphfLeF3o4isTvEcekFH8NybMlx+kOss9WrQvxVmI9t/Qz0+Ps0Zv0fDYKtTvQPrA/cy4XcjF9cRC/OForOSR8GOF1ifCpwluBTIdfENWwqGvbhgPQxj4lm/W1gKpKfCoZVi0twUWjxaunlLiM3sTkID0bygyE3hp8VWgkOwY0axGZoQYZiPsOFGloJHsGHCtJtbMyJD0U4Q7n8MO5UaH7WBvqk3+TpiNA0dmNBO4JVWIgT0qezags/4iQWdWq6WPrU1elbfkyG2lnj+CxMs3GsE+MnHRg/7sQ49k+i7mjr5M7hn+EPzTE23N4QdMkAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">الشروط و الاحكام</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('questions') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAACDElEQVRIie3WTYhOURgH8F/mwyjiNTWRUCym1JSSzcyoWVpYyYLSxFKRsPS1EPZWIxZKPhbE1oKiLKhJWEjJJDWSbwv56r0W99y67pz33vvOm2zmX6enzvN//v/znuecc1/m8J9xBF/wAmfQaKN2La7jLd7haFVBP67iK5LCeIDeGqYrglmx/jXWtSq6EinIj101jCdK6m/mifNCbGBriWCC+TWM15TkhmOTIyUrTXA48LqxH5P4hjfYl9Ppw60WGt9jxttKTJ+iCz0loq+wJ2gNSA9mkfMsZry9xPhg4Oyt2JUEo4F7PpJ7njfMetwVW03Aw9yuVGFniPcjud8x47Kr8j7EZTWMV4Y4HcmNx4wHaoi9rGGccZYW5u9JD+QM4w0lYiMhXqphfLeF3o4isTvEcekFH8NybMlx+kOss9WrQvxVmI9t/Qz0+Ps0Zv0fDYKtTvQPrA/cy4XcjF9cRC/OForOSR8GOF1ifCpwluBTIdfENWwqGvbhgPQxj4lm/W1gKpKfCoZVi0twUWjxaunlLiM3sTkID0bygyE3hp8VWgkOwY0axGZoQYZiPsOFGloJHsGHCtJtbMyJD0U4Q7n8MO5UaH7WBvqk3+TpiNA0dmNBO4JVWIgT0qezags/4iQWdWq6WPrU1elbfkyG2lnj+CxMs3GsE+MnHRg/7sQ49k+i7mjr5M7hn+EPzTE23N4QdMkAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">الاسئلة الشائعة</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('privacies') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAACDElEQVRIie3WTYhOURgH8F/mwyjiNTWRUCym1JSSzcyoWVpYyYLSxFKRsPS1EPZWIxZKPhbE1oKiLKhJWEjJJDWSbwv56r0W99y67pz33vvOm2zmX6enzvN//v/znuecc1/m8J9xBF/wAmfQaKN2La7jLd7haFVBP67iK5LCeIDeGqYrglmx/jXWtSq6EinIj101jCdK6m/mifNCbGBriWCC+TWM15TkhmOTIyUrTXA48LqxH5P4hjfYl9Ppw60WGt9jxttKTJ+iCz0loq+wJ2gNSA9mkfMsZry9xPhg4Oyt2JUEo4F7PpJ7njfMetwVW03Aw9yuVGFniPcjud8x47Kr8j7EZTWMV4Y4HcmNx4wHaoi9rGGccZYW5u9JD+QM4w0lYiMhXqphfLeF3o4isTvEcekFH8NybMlx+kOss9WrQvxVmI9t/Qz0+Ps0Zv0fDYKtTvQPrA/cy4XcjF9cRC/OForOSR8GOF1ifCpwluBTIdfENWwqGvbhgPQxj4lm/W1gKpKfCoZVi0twUWjxaunlLiM3sTkID0bygyE3hp8VWgkOwY0axGZoQYZiPsOFGloJHsGHCtJtbMyJD0U4Q7n8MO5UaH7WBvqk3+TpiNA0dmNBO4JVWIgT0qezags/4iQWdWq6WPrU1elbfkyG2lnj+CxMs3GsE+MnHRg/7sQ49k+i7mjr5M7hn+EPzTE23N4QdMkAAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">سياسة الخصوصية</span>
                            </a>
                        </li>
                    @endcan
                    @can('socials')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('socials') }}">
                                <i class="icon">
                                    <img width="16" height="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABmJLR0QA/wD/AP+gvaeTAAAGZUlEQVR4nO2bTW9VRRjHfxDbC6Et9JKQSAsksgCMaxYGUVioQYMv4FrFtn4DFBHKHvwCfgRsi5hoVGAhGqVCIUYShWIloDGBwG0LS5Lr4nmGM5w759yZM3OxKv9k0tt5e/4z58zb/zwDj/D/xiKPPHXgVWAnsBEY1Pi/gJ+BL4AxYLYTBEvQD+wGdgBPAY9r/B/AL8BnwKdAo6qBpcB+YA5otgkN4ABQq2osADVgFOnwdrxmgX3aliAMAOesir4GhoANwDING4Fh4ISVbxJYW7VlHlgHnK3A66y2yQsDwHUteAnYqvFrkFd9XsOEGgZ4FrisZX4HVldrXykGgasRvK7j0QlLyZ78N8g4M0Zu0fqK3SKbE+rAaY2/AHRVaWUBuoGfEvD6EVhSZmg/WQ/3W/FjGv+5VjyITH5N4KiVrw5Ma/y+0FY+JF7vFRmpk00sW3Np8xo/aMWt0bi5XN5tGj8P9LRrmQd6gTsJeTV4sBPvYw/ZxJJHiCGAk5r2jstQIIY7wOstE7HYStypf+1Xx+Ar/fuxGlijvwG+dOQ3dbzoSAOZHz4Cbmo4QvGc8UIHeO10pHEJ6Z0NjrT1wD1aJ5t7wBOO/Bs1fdplCGl8vq4jBXnN2A3ltb6E168uQ+Z16s3FDyDre9Fm4wzZLsygtyS/HZ4GtnjmDeU1SetybHjNuzrATDS2oZpl5BqwS9N7gdeQnjSdYO8CfTtgC/BMhQ6I5XXH1QGuV23EMlJ3lKmTbZqGrPhNGvebyxDyuucbeLgg70wkr2EHr8suQxOOAt9r3K4CcgBvaJ7vrLh3NW6ioEwX0gk3NBwGHivIe7wDvMZcBYY08YQVdxv3+LPRR7b7MjhF+mUwJa89rgIrkE1CE9lDg9/YtAPAdv09S8GGIxD9ZCfSFLxuA8uLjB0gGyN14NsAI6eBlcAV/f9gXLsfwGhCXh+UGbJn19O4J5girLSInUcOMKlQ0zpjef3gw2stcqRtIivDNg8j28l6uIkoRasCSLbDKq3T1F+F1wwBWsVq5EhrDJ5Elp5NyAGnB3gSmVVPWfnOAxcp7oQ+LTOhhO5qmAHGNa0vV8Zu/EWyNyGE1xStm7W26EKOtGaHWBbmkPmjO0fYdEI3cAg/GauBzB9dJXWN4ifVzSPH3yhtogdZzo6SbZbMJmcCWT7zs33+qU1Z5XxlrCnK36Z+reeYcrGHx1FkqVsW0/Ai2EtLGfLjtoqMFTKf+PKKhq+hbrInHyNjTeG3oiy4DjhE9uRjZSyfPcWC6oDlpJXXGrSuDlV4JYGPIXPoSCljjSTg1YLF7bPchznBGTxsGev5BLyi4JKxis7wZllKKWNdScArCje1clvGulGQ966mp5SxnCpOIK8WhAwBu4zPV+U8ash6vxlRa3YjE1sf8DqyWmzWPFU+slbl5Y0QGcs1BGJlrKIhEMIrCl1asW2kSMYap7UhsTLWJwl4JUHIMphSxhp2lgjjlQQ+hvrI5LXtuXK+AeA5/T1LiYwVwCsJfA0d1HwpZKwPE/KKRpXDUIyMdQ6/jc2C64AUMlaTBXAc7kUmoLEcsRnko8UwYYKIr4x1jvaCyAjiDTZjlbuCrBhDlE+4bdGNeGaYb4ZlYQ6RqWq4ZawuZE5oeNTVQMZ8kSRWQ47aPlLdHUQGDz4bDJL55DTxl7F8RNER5G2aJhNFp5GnNkKYKOrL6wIBjlvriPPGChm3vkghr13VtpWiRuaHFyNjdfLDSAyvSdqcM8wnqBQy1mhoK0uQUl4r3FP0k1bGmiPNx9G6ZT+VvLbCZagT3lhDjrRQmFNkR7zXbD1gh/5NKWO95EiDMC+xlzvAa4cjrSPeWEUuMiFeYi4XmVheThcZl5MUxMlY7cI/5SXmlNdcbnL/VS8xp5ucy1EyVsYqcpQMkbFivddcvJyOksccBWJlLNfEBWFeYmatT8lr3FXgbU3suDdWIDrhvfamq4C9EUrhjZXKXb6HbIJOwatwIwTiEWKWiVgZq/BiQgWk5LW3zNASssNQjIw1RforM8ZnKYbXJG2uzMCDl6aqemMFOyR5YDVx3mvXCNAEBpALRuY18pWxztD5a3NVeLk2RW2xBHgfPxnrNiI9pdQAilBDjrS+8tpeSjQAn4+J/cAryDWTTcjJaxHwJ9nV2XHcp69OYgWyDzBXZweQRpurs8c1POwrvY/wr8LfwBjFbvaqZX0AAAAASUVORK5CYII=">
                                </i>
                                <span class="item-name">{{ __('dashboard.socials') }}</span>
                            </a>
                        </li>
                    @endcan
                    
                    <hr>
                </ul>
                <!-- Sidebar Menu End -->
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
                <div class="container-fluid navbar-inner">
                    <a href="{{ route('admin') }}" class="navbar-brand">
                        <!--Logo start-->

                        @can('superAdmin')
                            <img width="20px" height="20px" src="{{ asset('Admin/images/logo/' . env('LOGO')) }}"
                                alt="">
                            <!--logo End-->
                            <h4 class="logo-title">{{ env('APP_NAME') }}</h4>
                        @endcan
                        @if (auth()->user()->role->name == 'Employee')
                            <img width="20px" height="20px" src="{{ asset('Admin/images/logo/' . env('LOGO')) }}"
                                alt="">
                            <!--logo End-->
                            <h4 class="logo-title">{{ env('APP_NAME') }}</h4>
                        @endif
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" height="20px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="mt-2 navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                            <li class="nav-item dropdown">
                                <a href="#" class="search-toggle nav-link" id="dropdownMenuButton2"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('Admin/assets/images/Flag/flag-400.png') }}"
                                        class="img-fluid rounded-circle" alt="user"
                                        style="height: 30px; min-width: 30px; width: 30px;">
                                    <span class="bg-primary"></span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (auth()->user()->image)
                                        <img src="{{ asset('Admin/images/admins/' . auth()->user()->image) }}"
                                            alt="User-Profile"
                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    @else
                                        <img src="{{ asset('Admin/assets/images/avatars/01.png') }}"
                                            alt="User-Profile"
                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    @endif
                                    <div class="caption ms-3 d-none d-md-block ">
                                        <h6 class="mb-0 caption-title">{{ auth()->user()->name }}</h6>
                                        <p class="mb-0 caption-sub-title">
                                            {{ auth()->user()->role->name }}
                                        </p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item"
                                            href="{{ route('logout') }}">{{ __('dashboard.Logout') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <br>
        <br>
        <!-- Nav Header Component Start -->
        @yield('main')


        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                {{-- <ul class="left-panel list-inline mb-0 p-0">
                <li class="list-inline-item"><a href="{{ asset('Admin/dashboard/extra/privacy-policy.html' )}}">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="{{ asset('Admin/dashboard/extra/terms-of-service.html' )}}">Terms of Use</a></li>
            </ul> --}}
                <div class="right-panel">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> تم انشاءه بواسطة <b>رؤي برمجية لتقنية المعلومات</b>
                    <span class="text-gray">
                        <svg width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z"
                                fill="currentColor"></path>
                        </svg>
                    </span> <a href="https://www..com/"></a>.
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>
    <!-- offcanvas start -->

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
    <script src="{{ asset('Admin/assets/vendor/aos/dist/aos.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('Admin/assets/js/hope-ui.js') }}" defer></script>
    @yield('head')
    <livewire:scripts />
    <script>
        function notifications() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $.post("/notificationsStatus", function(status, xhr) {
                console.log("success");
            })
        }

        function messages() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $.post("/messagesStatus", function(status, xhr) {})
        }
        $(document).ready(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_qMkPs4yuvegDb_pmoePvjoTy5L4H1rY&callback=myMap&v=weekly"
        defer></script>
    @yield('js')
</body>

</html>
