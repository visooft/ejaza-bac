@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            @if ($status == 0)
                                <h1>الاعلانات الجديدة</h1>
                            @elseif($status == 1)
                                <h1>الاعلانات المقبولة</h1>
                            @elseif($status == 2)
                                <h1>الاعلانات المرفوضة</h1>
                            @endif
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
                        @include('partials._session')
                        @include('partials._errors')
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.#') }}</th>
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th style="min-width: 300px">{{ __('dashboard.desc') }}</th>
                                            <th>القسم</th>
                                            <th>اللغه</th>
                                            <th>رقم الرخصه</th>
                                            <th>السعر</th>
                                            <th>iban</th>
                                            <th>صاحب الاعلان</th>
                                            <th>{{ __('dashboard.changeStatus') }}</th>
                                            <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ads as $key => $ad)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center"><img
                                                        class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ $ad->image }}" alt="Category"></td>
                                                <td>
                                                    <a href="{{ route('getDetialsgide', $ad->id) }}">
                                                        {{ $ad->trave_type->name_ar }}
                                                    </a>
                                                </td>
                                                <td style="white-space: pre-wrap;">{{ $ad->desc_ar }}</td>
                                                <td>{{ $ad->category->name_ar }}</td>
                                                <td>{{ $ad->language->name_ar }}</td>
                                                <td>{{ $ad->license_number }}</td>
                                                <td>{{ $ad->price }}</td>
                                                <td>{{ $ad->iban }}</td>
                                                <td>{{ $ad->user->name }}</td>
                                                <td>
                                                    @if ($status == 0)
                                                        <a href="{{ route('accepetResturantgide', $ad->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                                        <a href="{{ route('rejecetResturantgide', $ad->id) }}"
                                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                                    @elseif ($status == 1)
                                                        <a
                                                            class="btn btn-success">{{ __('dashboard.AccepetResturant') }}</a>
                                                    @elseif ($status == 2)
                                                        <a
                                                            class="btn btn-danger">{{ __('dashboard.rejecetResturant') }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">

                                                        <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                            data-placement="top" title="" data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $ad->id }}','delete')"
                                                            href="#deleteModal">
                                                            <span class="btn-inner">
                                                                <svg width="20" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    stroke="currentColor">
                                                                    <path
                                                                        d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M20.708 6.23975H3.75" stroke="currentColor"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        @if ($status == 1)
                                                            @if ($ad->show == 1)
                                                                <a class="btn btn-sm btn-icon"
                                                                    style="background-color:#3a57e8" data-bs-toggle="modal"
                                                                    data-placement="top" title=""
                                                                    data-original-title="hide"
                                                                    onclick="myFunction(this, '{{ $ad->id }}','hide')"
                                                                    href="#hidecategory">
                                                                    <span class="btn-inner">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a class="btn btn-sm btn-icon"
                                                                    style="background-color:#3a57e8" data-bs-toggle="modal"
                                                                    data-placement="top" title=""
                                                                    data-original-title="show"
                                                                    onclick="myFunction(this, '{{ $ad->id }}','show')"
                                                                    href="#showcategory">
                                                                    <span class="btn-inner">
                                                                        <svg style="color: rgb(0, 0, 0);"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16"
                                                                            fill="currentColor" class="bi bi-eye-slash"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"
                                                                                fill="#000000"></path>
                                                                            <path
                                                                                d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                                                                                fill="#000000"></path>
                                                                            <path
                                                                                d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                                                                                fill="#000000"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        @endif



                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {{ $ads->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal">حذف الاعلان</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('gide.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="categoryIdDelete" name="resturantId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="delete-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showcategory" tabindex="-1" aria-labelledby="showcategory" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showcategory">اظهار الاعلان</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="show-form" class="was-validated" action="{{ route('gide.show') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdShow" name="resturantId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="show-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.show') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="hidecategory" tabindex="-1" aria-labelledby="hidecategory" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hidecategory">اخفاء الاعلان</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="hide-form" class="was-validated" action="{{ route('gide.hide') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdHide" name="resturantId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="hide-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.hide') }}</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            function myFunction(e, id, type = "") {

                if (type == "delete") {
                    const e = document.getElementById('categoryIdDelete');
                    if (e) e.value = id;
                } else if (type == "show") {
                    const e = document.getElementById('categoryIdShow');
                    if (e) e.value = id;
                } else if (type == "hide") {
                    const e = document.getElementById('categoryIdHide');
                    if (e) e.value = id;
                }
            }
        </script>
    @endsection
