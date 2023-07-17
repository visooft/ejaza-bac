@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            @if ($status == 0)
                                <h1>{{ __('dashboard.newStores') }}</h1>
                            @elseif($status == 1)
                                <h1>{{ __('dashboard.AcceptedStores') }}</h1>
                            @elseif($status == 2)
                                <h1>{{ __('dashboard.rejectedStores') }}</h1>
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
                        <div class="card-header d-inline justify-content-center">
                            <div class="d-flex mb-4">
                                @can('superAdmin')
                                    @if ($status == 0)
                                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalDefault">
                                                {{ __('dashboard.addStore') }}
                                            </button>
                                        </div>
                                    @endif
                                @endcan
                                <div class="d-flex">
                                    @can('reports')
                                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                            <button onclick="ExportToExcel('xlsx')" type="button"
                                                class="btn btn-primary">{{ __('dashboard.reports') }}</button>
                                        </div>
                                    @endcan
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
                                            <th style="min-width: 300px">{{ __('dashboard.desc') }}</th>
                                            <th>{{ __('dashboard.category') }}</th>
                                            <th>{{ __('dashboard.storeOwner') }}</th>
                                            <th>{{ __('dashboard.rate') }}</th>
                                            <th>{{ __('dashboard.status') }}</th>
                                            @if ($status == 2 || $status == 1)
                                                <th>{{ __('dashboard.changeStatus') }}</th>
                                            @endif
                                            <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stores as $key => $store)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center"><img
                                                        class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ $store->logo }}" alt="Category"></td>
                                                <td><a onclick="getResturantData(this, '{{ $store->id }}')"
                                                        href="#resturantModel" data-bs-toggle="modal" data-placement="top"
                                                        title="resturant"
                                                        data-original-title="resturant">{{ $store->name }}</a></td>
                                                <td style="white-space: pre-wrap;">{{ $store->desc }}</td>
                                                <td>
                                                    @if (app()->getLocale() == 'ar')
                                                        {{ $store->category->name_ar }}
                                                    @else
                                                        {{ $store->category->name_en }}
                                                    @endif
                                                </td>
                                                <td><a onclick="getUserData(this, '{{ $store->user_id }}')"
                                                        href="#senderModel" data-bs-toggle="modal" data-placement="top"
                                                        title="sender"
                                                        data-original-title="sender">{{ $store->user->name }}</a></td>
                                                <td>{{ $store->rate }}</td>
                                                <td>
                                                    @if ($status == 0)
                                                        <a href="{{ route('accepetStore', $store->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                                        <a href="{{ route('rejecetStore', $store->id) }}"
                                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                                    @elseif ($status == 1)
                                                        <a class="btn btn-success">{{ __('dashboard.AccepetStore') }}</a>
                                                    @elseif ($status == 2)
                                                        <a class="btn btn-danger">{{ __('dashboard.rejecetStore') }}</a>
                                                    @endif
                                                </td>
                                                @if ($status == 2)
                                                    <td>
                                                        <a href="{{ route('accepetStore', $store->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                                    </td>
                                                @elseif($status == 1)
                                                    <td>
                                                        <a href="{{ route('rejecetStore', $store->id) }}"
                                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                                    </td>
                                                @endif
                                                </td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-success"
                                                            href="{{ route('submenues', $store->id) }}">
                                                            <span class="btn-inner">
                                                                <svg width="20" height="20"
                                                                    enable-background="new 0 0 512 512" height="512px"
                                                                    id="Layer_1" version="1.1" viewBox="0 0 512 512"
                                                                    width="512px" xml:space="preserve"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                    <path
                                                                        d="M256,512C114.625,512,0,397.391,0,256C0,114.609,114.625,0,256,0c141.391,0,256,114.609,256,256  C512,397.391,397.391,512,256,512z M256,64C149.969,64,64,149.969,64,256s85.969,192,192,192c106.047,0,192-85.969,192-192  S362.047,64,256,64z M288,384h-64v-96h-96v-64h96v-96h64v96h96v64h-96V384z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal"
                                                            data-placement="top" title=""
                                                            data-original-title="Update"
                                                            onclick="myFunction(this, '{{ $store->id }}', '{{ $store->name_ar }}' , '{{ $store->name_en }}', '{{ $store->desc_ar }}', '{{ $store->desc_en }}', '{{ $store->phone }}', '{{ $store->lat }}', '{{ $store->long }}', '{{ $store->address }}', '{{ $store->time }}', '{{ $store->delivaryCost }}', '{{ $store->resturantPhone }}','{{ $store->category_id }}','update', '{{ $store->link }}')"
                                                            href="#editmodel">
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
                                                            data-placement="top" title=""
                                                            data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $store->id }}', '{{ $store->name_ar }}' , '{{ $store->name_en }}', '{{ $store->desc_ar }}', '{{ $store->desc_en }}', '{{ $store->phone }}', '{{ $store->lat }}', '{{ $store->long }}', '{{ $store->address }}', '{{ $store->time }}', '{{ $store->delivaryCost }}', '{{ $store->resturantPhone }}','{{ $store->category_id }}','delete', '{{ $store->link }}')"
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
                                                        @if ($store->show == 1)
                                                            <a class="btn btn-sm btn-icon"
                                                                style="background-color:#3a57e8" data-bs-toggle="modal"
                                                                data-placement="top" title=""
                                                                data-original-title="hide"
                                                                onclick="myFunction2(this, '{{ $store->id }}','hide')"
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
                                                                onclick="myFunction2(this, '{{ $store->id }}','show')"
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
                                        @endforeach


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
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.addStore') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="submit-form" class="was-validated" action="{{ route('stores.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.name_ar') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.name_ar') }}" type="text" name="name_ar"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.name_en') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.name_en') }}" type="text" name="name_en"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                    <textarea name="desc_ar" class="form-control is-invalid" id="validationTextarea" cols="30" rows="3"
                                        required placeholder="{{ __('dashboard.desc_ar') }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_en') }}</label>
                                    <textarea name="desc_en" class="form-control is-invalid" id="validationTextarea" cols="30" rows="3"
                                        required placeholder="{{ __('dashboard.desc_en') }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storeOwnerPhone') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.storeOwnerPhone') }}" maxlength="10"
                                        name="phone" pattern="[0-9]+" title="{{ __('dashboard.storeOwnerPhone') }}"
                                        type="tel" required>
                                </div>

                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.lat') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.lat') }}" name="lat"
                                        title="{{ __('dashboard.lat') }}" type="number" min="0"
                                        step="0.000000001" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.long') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.long') }}" maxlength="10" name="long"
                                        title="{{ __('dashboard.long') }}" type="number" step="0.000000001"
                                        min="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.address') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.address') }}" name="address" type="text"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storeLink') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.storeLink') }}" name="link" type="url">
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storePhone') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.storePhone') }}" maxlength="10" name="storePhone"
                                        pattern="[0-9]+" title="{{ __('dashboard.storePhone') }}" type="tel"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.delivaryCost') }}
                                        ({{ __('dashboard.Rial') }})</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.delivaryCost') }}" name="delivaryCost"
                                        title="{{ __('dashboard.delivaryCost') }}" type="number" min="0"
                                        step="0.1" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.time') }}
                                        ({{ __('dashboard.minute') }})</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.time') }}" maxlength="10" name="time"
                                        title="{{ __('dashboard.time') }}" type="number" min="0"
                                        step="0.1" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.category') }}</label>
                                    <select required name="categoryId" class="form-select" aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.logo') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input required name="logo" type="file" class="form-control"
                                        aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.backGround') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input required name="backGround" type="file" class="form-control"
                                        aria-label="file example">
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
        <div class="modal fade" id="editmodel" tabindex="-1" aria-labelledby="editmodel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editmodel">{{ __('dashboard.updateStore') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="update-form" class="was-validated" action="{{ route('stores.update') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="storeId" id="storeId">
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.name_ar') }}</label>
                                    <input class="form-control is-invalid" id="name_ar"
                                        placeholder="{{ __('dashboard.name_ar') }}" type="text" name="name_ar"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.name_en') }}</label>
                                    <input class="form-control is-invalid" id="name_en"
                                        placeholder="{{ __('dashboard.name_en') }}" type="text" name="name_en"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                    <textarea name="desc_ar" class="form-control is-invalid" id="desc_ar" cols="30" rows="3" required
                                        placeholder="{{ __('dashboard.desc_ar') }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_en') }}</label>
                                    <textarea name="desc_en" class="form-control is-invalid" id="desc_en" cols="30" rows="3" required
                                        placeholder="{{ __('dashboard.desc_en') }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storeOwnerPhone') }}</label>
                                    <input class="form-control is-invalid" id="userPhone"
                                        placeholder="{{ __('dashboard.storeOwnerPhone') }}" maxlength="10"
                                        name="phone" pattern="[0-9]+" title="{{ __('dashboard.storeOwnerPhone') }}"
                                        type="tel" required>
                                </div>

                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.lat') }}</label>
                                    <input class="form-control is-invalid" id="restLat"
                                        placeholder="{{ __('dashboard.lat') }}" name="lat"
                                        title="{{ __('dashboard.lat') }}" type="number" min="0"
                                        step="0.000000001" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.long') }}</label>
                                    <input class="form-control is-invalid" id="restLong"
                                        placeholder="{{ __('dashboard.long') }}" maxlength="10" name="long"
                                        title="{{ __('dashboard.long') }}" type="number" step="0.000000001"
                                        min="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.address') }}</label>
                                    <input class="form-control is-invalid" id="restAddress"
                                        placeholder="{{ __('dashboard.address') }}" name="address" type="text"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storeLink') }}</label>
                                    <input class="form-control is-invalid" id="restLink"
                                        placeholder="{{ __('dashboard.storeLink') }}" name="link" type="url">
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.storePhone') }}</label>
                                    <input class="form-control is-invalid" id="storePhone"
                                        placeholder="{{ __('dashboard.storePhone') }}" maxlength="10" name="storePhone"
                                        pattern="[0-9]+" title="{{ __('dashboard.storePhone') }}" type="tel"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.delivaryCost') }}
                                        ({{ __('dashboard.Rial') }})</label>
                                    <input class="form-control is-invalid" id="restCost"
                                        placeholder="{{ __('dashboard.delivaryCost') }}" name="delivaryCost"
                                        title="{{ __('dashboard.delivaryCost') }}" type="number" min="0"
                                        step="0.1" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.time') }}
                                        ({{ __('dashboard.minute') }})</label>
                                    <input class="form-control is-invalid" id="restTime"
                                        placeholder="{{ __('dashboard.time') }}" maxlength="10" name="time"
                                        title="{{ __('dashboard.time') }}" type="number" min="0"
                                        step="0.1" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.category') }}</label>
                                    <select required name="categoryId" id="categoryId" class="form-select"
                                        aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.logo') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input name="logo" type="file" class="form-control" aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.backGround') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input name="backGround" type="file" class="form-control"
                                        aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="update-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.add') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal">{{ __('dashboard.deleteStore') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('stores.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="categoryIdDelete" name="storeId" type="hidden" class="form-control">
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
                        <h5 class="modal-title" id="showcategory">{{ __('dashboard.showStore') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="show-form" class="was-validated" action="{{ route('stores.show') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdShow" name="storeId" type="hidden" class="form-control">
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
                        <h5 class="modal-title" id="hidecategory">{{ __('dashboard.hideStore') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="hide-form" class="was-validated" action="{{ route('stores.hide') }}" method="POST">
                            @csrf
                            @method('put')
                            <input id="categoryIdHide" name="storeId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="hide-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.hide') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="senderModel" tabindex="-1" aria-labelledby="senderModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="senderModel">{{ __('dashboard.userDetials') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.#') }}</label>
                                <input class="form-control" id="id" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.name') }}</label>
                                <input class="form-control" id="name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.email') }}</label>
                                <input class="form-control" id="email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.phone') }}</label>
                                <input class="form-control" id="phone" readonly>
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
        <div class="modal fade" id="resturantModel" tabindex="-1" aria-labelledby="resturantModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="senderModel">{{ __('dashboard.ResturantDetials') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.time') }}
                                    ({{ __('dashboard.minute') }})</label>
                                <input class="form-control" id="time" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.delivaryCost') }}
                                    ({{ __('dashboard.Rial') }})</label>
                                <input class="form-control" id="delivaryCost" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.lat') }}</label>
                                <input class="form-control" id="lat" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.long') }}</label>
                                <input class="form-control" id="long" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.address') }}</label>
                                <input class="form-control" id="address" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.link') }}</label>
                                <input class="form-control" id="link" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.resturnPhone') }}</label>
                                <input class="form-control" id="resturantPhone" readonly>
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
        <script>
            function myFunction(e, id, name_ar, name_en, desc_ar, desc_en, phone, lat, long, address, time, delivaryCost,
                resturantPhone, category_id, type = "", link) {
                if (type == "update") {
                    const e = document.getElementById('storeId');
                    if (e) {
                        e.value = id;
                        document.getElementById('name_ar').value = name_ar;
                        document.getElementById('name_en').value = name_en;
                        document.getElementById('desc_ar').value = desc_ar;
                        document.getElementById('desc_en').value = desc_en;
                        document.getElementById('userPhone').value = phone;
                        document.getElementById('restLat').value = lat;
                        document.getElementById('restLong').value = long;
                        document.getElementById('restAddress').value = address;
                        document.getElementById('storePhone').value = resturantPhone;
                        document.getElementById('restCost').value = delivaryCost;
                        document.getElementById('restTime').value = time;
                        document.getElementById('categoryId').value = category_id;
                        document.getElementById('restLink').value = link;
                    }
                } else if (type == "delete") {
                    const e = document.getElementById('categoryIdDelete');
                    if (e) e.value = id;
                }
            }

            function myFunction2(e, id, type = "") {
                if (type == "show") {
                    const e = document.getElementById('categoryIdShow');
                    if (e) e.value = id;
                } else if (type == "hide") {
                    console.log(id);
                    const e = document.getElementById('categoryIdHide');
                    if (e) e.value = id;
                }
            }
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

            function hideRow(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
                    el.cells[7].remove(7)
                    el.cells[6].remove(6)
                    el.cells[0].remove(0)
                })
                location.reload(true);
            }

            function hideRowAccepet(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
                    el.cells[8].remove(8)
                    el.cells[7].remove(7)
                    el.cells[6].remove(6)
                    el.cells[0].remove(0)
                })
                location.reload(true);
            }

            function hideRowRejecet(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
                    el.cells[8].remove(8)
                    el.cells[7].remove(7)
                    el.cells[6].remove(6)
                    el.cells[0].remove(0)
                })
                location.reload(true);
            }


            function ExportToExcel(type, fn, dl) {
                var elt = document.getElementById('user-list-table');
                @if ($status == 0)
                    hideRow(elt);
                    var wb = XLSX.utils.table_to_book(elt, {
                        sheet: "sheet1"
                    });
                @endif
                @if ($status == 1)
                    hideRowAccepet(elt);
                    var wb = XLSX.utils.table_to_book(elt, {
                        sheet: "sheet1"
                    });
                @endif
                @if ($status == 2)
                    hideRowRejecet(elt);
                    var wb = XLSX.utils.table_to_book(elt, {
                        sheet: "sheet1"
                    });
                @endif


                return dl ?
                    XLSX.write(wb, {
                        bookType: type,
                        bookSST: true,
                        type: 'base64'
                    }) :
                    @if ($status == 0)
                        XLSX.writeFile(wb, fn || ('المتاجر الجديده.' + (type || 'xlsx')));
                    @endif
                @if ($status == 1)
                    XLSX.writeFile(wb, fn || ('المتاجر المقبولة.' + (type || 'xlsx')));
                @endif
                @if ($status == 2)
                    XLSX.writeFile(wb, fn || ('المتاجر المرفوضة.' + (type || 'xlsx')));
                @endif
            }
        </script>
    @endsection
