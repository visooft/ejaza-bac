@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>طرق الدفع</h1>
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
                                <table id="user-list-table" class="table table-striped" role="grid"
                                       data-toggle="data-table">
                                    <thead>
                                    <tr class="ligth">
                                        <th>{{ __('dashboard.#') }}</th>
                                        <th>{{ __('dashboard.name') }}</th>
                                        <th>{{ __('dashboard.status') }}</th>
                                        <th>{{ __('dashboard.image') }}</th>
                                        @can('superAdmin')
                                            <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                        @endcan

                                    </tr>
                                    </thead>
                                    <tbody class="drag-sort-enable">
                                    @foreach ($payments as $key => $payment)
                                        <tr class="item">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $payment->name }}
                                            </td>
                                            <td>
                                                @if($payment->status == 1)
                                                    <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($payment->image as $image)
                                                    <img src="{{ asset($image) }}"
                                                         alt="image" class="img-fluid" width="50px">
                                                @endforeach
                                            </td>
                                            @can('superAdmin')
                                                <td>
                                                    <div class="flex align-items-center list-user-action">

                                                        <a class="btn btn-sm btn-icon btn-warning"
                                                           data-bs-toggle="modal"
                                                           data-placement="top" title="" data-original-title="Edit"
                                                           onclick="myFunction(this, '{{ $payment->id }}','{{ $payment->name }}' ,'{{ $payment->status }}' ,'update')"
                                                           href="#editModal">
                                                <span class="btn-inner">
                                                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                                                            stroke="currentColor" stroke-width="1.5"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                              d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                                                              stroke="currentColor" stroke-width="1.5"
                                                                              stroke-linecap="round"
                                                                              stroke-linejoin="round">
                                                                        </path>
                                                                        <path d="M15.1655 4.60254L19.7315 9.16854"
                                                                              stroke="currentColor" stroke-width="1.5"
                                                                              stroke-linecap="round"
                                                                              stroke-linejoin="round">
                                                                        </path>
                                                                    </svg>
                                                                </span>
                                                        </a>
                                                        @if ($payment->status == 1)
                                                            <a class="btn btn-sm btn-icon"
                                                               style="background-color:#3a57e8" data-bs-toggle="modal"
                                                               data-placement="top" title=""
                                                               data-original-title="hide"
                                                               onclick="myFunction(this, '{{ $payment->id }}','{{ $payment->name }}' ,'{{ $payment->status }}', 'hide')"
                                                               href="#hideSlider">
                                                                    <span class="btn-inner">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="24"
                                                                             height="24" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/>
                                                                        </svg>
                                                                    </span>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-sm btn-icon"
                                                               style="background-color:#3a57e8" data-bs-toggle="modal"
                                                               data-placement="top" title=""
                                                               data-original-title="show"
                                                               onclick="myFunction(this, '{{ $payment->id }}','{{ $payment->name }}' ,'{{ $payment->status }}', 'show')"
                                                               href="#showSlider">
                                                                    <span class="btn-inner">
                                                                        <svg style="color: rgb(0, 0, 0);"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             width="16"
                                                                             height="16" fill="currentColor"
                                                                             class="bi bi-eye-slash"
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
                                                    </div>
                                                </td>
                                            @endcan

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
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">تحديث طريقة الدفع</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="update-form" class="was-validated" action="{{ route('payments.update') }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input id="payId" name="payId" type="hidden" class="form-control">
                                <div class="form-group">
                                    <label for="validationTextarea"
                                           class="form-label">{{ __('dashboard.name') }}</label>
                                    <input class="form-control is-invalid" id="name"
                                           placeholder="{{ __('dashboard.name') }}" type="text" name="name"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">الصور</label>
                                    <input class="form-control" id="image"
                                           type="file" name="image[]" multiple>
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
        <div class="modal fade" id="showSlider" tabindex="-1" aria-labelledby="showSlider" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showSlider">اظهار طريقة الدفع</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="show-form" class="was-validated" action="{{ route('payments.show') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="sliderIdShow" name="payId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="show-form" type="submit"
                                class="btn btn-primary">{{ __('dashboard.show') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="hideSlider" tabindex="-1" aria-labelledby="hideSlider" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hideSlider">اخفاء طريقة الدفع</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="hide-form" class="was-validated" action="{{ route('payments.hide') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="sliderIdHide" name="payId" type="hidden" class="form-control">
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
            function myFunction(e, id, name, status, type = "") {
                if (type == "update") {
                    const e = document.getElementById('payId');
                    if (e) {
                        e.value = id;
                        document.getElementById('name').value = name;
                        document.getElementById('status').value = status;
                    }
                } else if (type == "delete") {
                    const e = document.getElementById('payIdDelete');
                    if (e) e.value = id;
                } else if (type == "show") {
                    const e = document.getElementById('sliderIdShow');
                    if (e) e.value = id;
                } else if (type == "hide") {
                    const e = document.getElementById('sliderIdHide');
                    if (e) e.value = id;
                }
            }
        </script>
@endsection
