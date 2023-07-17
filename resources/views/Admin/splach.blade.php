@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>splach</h1>
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
    </div> <!-- Nav Header Component End -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-inline justify-content-center">
                            <div class="d-flex mb-4">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalDefault">
                                        اضافة splach 
                                    </button>
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
                                            <th>العنوان</th>
                                            <th>{{ __('dashboard.desc') }}</th>
                                            @can('superAdmin')
                                                <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                            @endcan

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sliders as $key => $slider)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center"><img
                                                        class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ $slider->image }}" alt="Slider">
                                                </td>

                                                <td>{{ $slider->title }}</td>
                                                <td>{!! mb_strimwidth($slider->desc, 0, 50, ',...') !!}</td>
                                                @can('superAdmin')
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">

                                                            <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal"
                                                                data-placement="top" title="" data-original-title="Edit"
                                                                onclick="myFunction(this, '{{ $slider->id }}', '{{ $slider->title_ar }}', '{{ $slider->title_en }}', '{{ $slider->title_tr }}','{{ $slider->desc_ar }}', '{{ $slider->desc_en }}', '{{ $slider->desc_tr }}','update')"
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
                                                                onclick="myFunction(this, '{{ $slider->id }}', '{{ $slider->title_ar }}', '{{ $slider->title_en }}', '{{ $slider->title_tr }}','{{ $slider->desc_ar }}', '{{ $slider->desc_en }}', '{{ $slider->desc_tr }}', 'delete')"
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
                        <h5 class="modal-title" id="exampleModalLabel">اضافة splach </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="submit-form" class="was-validated" action="{{ route('splach.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالعربي
                                    </label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="العنوان بالعربي" type="text" name="title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالانجليزي</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="العنوان بالانجليزي" type="text" name="title_en" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالتركي</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="العنوان بالتركي" type="text" name="title_tr" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.desc_ar') }}" type="text" name="desc_ar"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_en') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.desc_en') }}" type="text" name="desc_en"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">الوصف بالتركي</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="الوصف بالتركي" type="text" name="desc_tr" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.image') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input required name="image" type="file" class="form-control"
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
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">تحديث splach </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="update-form" class="was-validated" action="{{ route('splach.update') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input id="sliderId" name="sliderId" type="hidden" class="form-control">
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالعربي
                                    </label>
                                    <input class="form-control is-invalid" placeholder="العنوان بالعربي" type="text"
                                        name="title_ar" id="title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالانجليزي</label>
                                    <input class="form-control is-invalid" placeholder="العنوان بالانجليزي"
                                        type="text" name="title_en" id="title_en" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">العنوان بالتركي</label>
                                    <input class="form-control is-invalid" placeholder="العنوان بالتركي" type="text"
                                        name="title_tr" id="title_tr" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.desc_ar') }}" type="text" name="desc_ar"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.desc_en') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.desc_en') }}" type="text" name="desc_en"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">الوصف بالتركي</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="الوصف بالتركي" type="text" name="desc_tr" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.image') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input name="image" type="file" class="form-control" aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
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
                        <h5 class="modal-title" id="deleteModal">حذف splach </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('splach.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="sliderIdDelete" name="sliderId" type="hidden" class="form-control">
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
            function myFunction(e, id, title_ar, title_en, title_tr, desc_ar, desc_en, desc_tr, type = "") {
                if (type == "update") {
                    console.log(id);
                    const e = document.getElementById('sliderId');
                    if (e) {
                        e.value = id;
                        document.getElementById('title_ar').value = title_ar;
                        document.getElementById('title_en').value = title_en;
                        document.getElementById('title_tr').value = title_tr;
                        document.getElementById('desc_ar').value = desc_ar;
                        document.getElementById('desc_en').value = desc_en;
                        document.getElementById('desc_tr').value = desc_tr;
                    }
                } else if (type == "delete") {
                    const e = document.getElementById('sliderIdDelete');
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
