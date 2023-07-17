@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.products') }}</h1>
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
                        <div class="card-header d-inline justify-content-center">
                            <div class="d-flex mb-4">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <a href="{{ route('products.add', $id) }}" class="btn btn-primary">
                                        {{ __('dashboard.addProduct') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @include('partials._session')
                        @include('partials._errors')
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid"
                                    data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.#') }}</th>
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.desc') }}</th>
                                            <th>{{ __('dashboard.view') }}</th>
                                            <th>{{ __('dashboard.star') }}</th>
                                            <th>{{ __('dashboard.offer') }}</th>
                                            <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center"><img
                                                        class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ $product->image }}" alt="Category"></td>
                                                <td><a href="#senderModel{{ $product->id }}" data-bs-toggle="modal"
                                                        data-placement="top" title="sender"
                                                        data-original-title="sender">{{ $product->name }}</a></td>
                                                <td>{{ $product->desc }}</td>
                                                <td>{{ $product->view }}</td>
                                                <td>
                                                    @if ($product->star == 0)
                                                        <a href="{{ route('addStar', $product->id) }}"
                                                            class="btn btn-danger">{{ __('dashboard.addStar') }}</a>
                                                    @else
                                                        <a href="{{ route('deleteStar', $product->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.deleteStar') }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $product->offers }} %</td>

                                                <td>
                                                    <div class="flex align-items-center list-user-action">

                                                        <a class="btn btn-sm btn-icon btn-warning"
                                                            href="{{ route('editProduct', $product->id) }}">
                                                            <span class="btn-inner">
                                                                <svg width="20" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M15.1655 4.60254L19.7315 9.16854"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                            data-placement="top" title="Delete" data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $product->id }}', 'delete')"
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
                                                        @if ($product->status == 1)
                                                            <a class="btn btn-sm btn-icon"
                                                                style="background-color:#3a57e8" data-bs-toggle="modal"
                                                                data-placement="top" title=""
                                                                data-original-title="hide"
                                                                onclick="myFunction(this, '{{ $product->id }}', 'hide')"
                                                                href="#hidecategory">
                                                                <span class="btn-inner">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24">
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
                                                                onclick="myFunction(this, '{{ $product->id }}' ,'show')"
                                                                href="#showcategory">
                                                                <span class="btn-inner">
                                                                    <svg style="color: rgb(0, 0, 0);"
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="currentColor"
                                                                        class="bi bi-eye-slash" viewBox="0 0 16 16">
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
                                            </tr>
                                            <div class="modal fade" id="senderModel{{ $product->id }}" tabindex="-1"
                                                aria-labelledby="senderModel{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="senderModel">
                                                                {{ __('dashboard.productDetials') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                @php
                                                                    $productDetials = \App\Models\ProductDetials::where('product_id', $product->id)->get();
                                                                @endphp
                                                                @foreach ($productDetials as $data)
                                                                    @php
                                                                        $size = \App\Models\Size::find($data->size_id);
                                                                        if (app()->getLocale() == 'ar') {
                                                                            $name = $size->name_ar;
                                                                        } else {
                                                                            $name = $size->name_en;
                                                                        }
                                                                    @endphp
                                                                    <div class="form-group">
                                                                        <label for="validationTextarea"
                                                                            class="form-label">{{ __('dashboard.size') }}</label>
                                                                        <input class="form-control"
                                                                            value="{{ $name }}
                                                                "
                                                                            readonly>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="validationTextarea"
                                                                            class="form-label">{{ __('dashboard.price') }}</label>
                                                                        <input class="form-control"
                                                                            value="{{ $data->price }}" readonly>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </tbody>
                                </table>
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
                        <h5 class="modal-title" id="deleteModal">{{ __('dashboard.delteProduct') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('products.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="categoryIdDelete" name="productId" type="hidden" class="form-control">
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
                        <h5 class="modal-title" id="showcategory">{{ __('dashboard.showProduct') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="show-form" class="was-validated" action="{{ route('products.show') }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdShow" name="productId" type="hidden" class="form-control">
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
                        <h5 class="modal-title" id="hidecategory">{{ __('dashboard.hideProduct') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="hide-form" class="was-validated" action="{{ route('products.hide') }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdHide" name="productId" type="hidden" class="form-control">
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

            function getUserData(e, id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (id) {
                    $.post("/messages/getData", {
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

            function add(e) {
                var new_chq_no = parseInt($('#total_chq').val()) + 1;
                var newDiv = `<div class="form-group" id='new_${new_chq_no}'>
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.size') }}</label>
                                <select required name="size[]" class="form-select" aria-label="select example">
                                    <option value="">{{ __('dashboard.openSelect') }}</option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.price') }}</label>
                                    <input required class="form-control is-invalid" id="validationTextarea" placeholder="{{ __('dashboard.price') }}" type="text" name="price[]">
                                </div>
                            </div>`;
                $('#new_chq').append(newDiv);
                $('#total_chq').val(new_chq_no)
                e.preventDefault()
            }

            function remove(e) {
                var last_chq_no = $('#total_chq').val();
                if (last_chq_no > 1) {
                    $('#new_' + last_chq_no).remove();
                    $('#total_chq').val(last_chq_no - 1);
                }
                e.preventDefault()
            }
        </script>
    @endsection
