@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.additionsDetials') }}</h1>
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
                            <div class="d-flex">

                                @can('merchant')
                                    <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDefault">
                                            {{ __('dashboard.add') }}
                                        </button>
                                    </div>
                                @endcan
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
                                            <th>{{ __('dashboard.name') }}</th>
                                            @can('merchant')
                                                <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($additions as $key => $addition)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $addition->name }}</td>
                                                @can('merchant')
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">

                                                            <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal"
                                                                data-placement="top" title="" data-original-title="Edit"
                                                                onclick="myFunction(this, '{{ $addition->id }}', '{{ $addition->name_ar }}' , '{{ $addition->name_en }}' ,'update')"
                                                                href="#editModal">
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
                                                                data-placement="top" title="" data-original-title="Delete"
                                                                onclick="myFunction(this, '{{ $addition->id }}', '{{ $addition->name_ar }}' , '{{ $addition->name_en }}' ,'delete')"
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
        <div class="modal fade" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.add') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="submit-form" class="was-validated" action="{{ route('addtions.storeAddition') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="additionId" value="{{ $id }}">
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
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">{{ __('dashboard.update') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="update-form" class="was-validated" action="{{ route('addtions.deleteAddition') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input id="categoryId" name="additionId" type="hidden" class="form-control">
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal">{{ __('dashboard.delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('addtions.deleteAddition') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="categoryIdDelete" name="additionId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="delete-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function myFunction(e, id, name_ar, name_en, type = "") {
                if (type == "update") {
                    const e = document.getElementById('categoryId');
                    if (e) {
                        e.value = id;
                        document.getElementById('name_ar').value = name_ar;
                        document.getElementById('name_en').value = name_en;
                    }
                } else if (type == "delete") {
                    const e = document.getElementById('categoryIdDelete');
                    if (e) e.value = id;
                }
            }
        </script>
    @endsection
