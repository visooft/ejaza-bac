@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.embloyee') }}</h1>
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
                                    <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDefault">
                                            {{ __('dashboard.addEmployee') }}
                                        </button>
                                    </div>
                                @endcan
                                <div class="d-flex">
                                    @can('reports')
                                        <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                            <button onclick="ExportToExcel('xlsx')" type="button"
                                                class="btn btn-primary">{{ __('dashboard.reports') }}</button>
                                        </div>
                                    @endcan
                                    @can('reports_seller')
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
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.email') }}</th>
                                            <th>{{ __('dashboard.phone') }}</th>
                                            <th>الدولة
                                            <th>{{ __('dashboard.date') }}</th>
                                            <th>{{ __('dashboard.block') }}</th>
                                            @can('superAdmin')
                                                <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                            @endcan

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($embloyees as $embloyee)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($embloyee->image)
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ asset('Admin/images/employees/' . $embloyee->image) }}"
                                                            alt="{{ $embloyee->name }}">
                                                    @else
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="https://ui-avatars.com/api/?name={{ $embloyee->name }}"
                                                            alt="{{ $embloyee->name }}">
                                                    @endif
                                                </td>
                                                <td>{{ $embloyee->name }}</td>
                                                <td>{{ $embloyee->email }}</td>
                                                <td>{{ $embloyee->phone }}</td>
                                                <td>{{ $embloyee->country }}</td>
                                                <td>{{ $embloyee->created_at }}</td>
                                                <td>
                                                    @if ($embloyee->status != 3)
                                                        <a class="btn btn-sm btn-icon btn-danger"
                                                            href="{{ route('block', $embloyee->id) }}">
                                                            {{ __('dashboard.block') }}</a>
                                                    @else
                                                        <a class="btn btn-sm btn-icon btn-success"
                                                            href="{{ route('unBlock', $embloyee->id) }}">
                                                            {{ __('dashboard.unBlock') }}</a>
                                                    @endif
                                                </td>
                                                @can('superAdmin')
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">

                                                            <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal"
                                                                data-placement="top" title="" data-original-title="Edit"
                                                                onclick="myFunction(this, '{{ $embloyee->id }}' ,'{{ $embloyee->name }}', '{{ $embloyee->phone }}' , '{{ $embloyee->email }}', '{{ $embloyee->role_id }}', '{{ $embloyee->country_id }}' ,'update')"
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
                                                                            d="M8.82812 10.921L16.3011 3.447d99C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
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
                                                                onclick="myFunction(this, '{{ $embloyee->id }}' ,'{{ $embloyee->name }}', '{{ $embloyee->phone }}' , '{{ $embloyee->email }}', '{{ $embloyee->role_id }}', '{{ $embloyee->country_id }}' ,'delete')"
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
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __('dashboard.addEmployee') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="submit-form" class="was-validated" action="{{ route('embloyee.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">
                                        {{ __('dashboard.employeeName') }}
                                    </label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.employeeName') }}" name="name" type="text"
                                        maxlength="200" required>

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.employeeEmail') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.employeeEmail') }}" name="email" type="email"
                                        required>

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.phoneNumberemployee') }}</label>
                                    <input class="form-control is-invalid" id="validationTextarea"
                                        placeholder="{{ __('dashboard.phoneNumberemployee') }}" maxlength="10"
                                        name="phone" pattern="[0-9]+"
                                        title="{{ __('dashboard.validationTitlePhone') }}" type="tel" required>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">الدولة</label>
                                    <select name="country_id" class="form-select" required aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.roles') }}</label>
                                    <select name="role_id" class="form-select" required aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.image') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input id="" name="image" type="file" class="form-control"
                                        aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.validationPassword') }}</label>
                                    <input class="form-control is-invalid" id="password"
                                        placeholder="{{ __('dashboard.password') }}" name="password" type="password"
                                        required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="{{ __('dashboard.titlePassword') }}">

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.confirmPassword') }}</label>
                                    <input class="form-control is-invalid" id="confirm_password"
                                        {{ __('dashboard.confirmPassword') }} name="password_confirmation"
                                        type="password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="{{ __('dashboard.titlePassword') }}">
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
                        <h5 class="modal-title" id="editModal">{{ __('dashboard.updateemployee') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">

                            <form id="update-form" class="was-validated" action="{{ route('embloyee.update') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input type="hidden" id="userIdForUpdate" name="userId">
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">
                                        {{ __('dashboard.employeeName') }}
                                    </label>
                                    <input class="form-control is-invalid" id="name"
                                        placeholder="{{ __('dashboard.employeeName') }}" name="name" type="text"
                                        maxlength="200" required>

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.employeeEmail') }}</label>
                                    <input class="form-control is-invalid" id="email"
                                        placeholder="{{ __('dashboard.employeeEmail') }}" name="email" type="email"
                                        required>

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.phoneNumberemployee') }}</label>
                                    <input class="form-control is-invalid" id="phone"
                                        placeholder="{{ __('dashboard.phoneNumberemployee') }}" maxlength="10"
                                        name="phone" type="tel" pattern="[0-9]+"
                                        title="{{ __('dashboard.validationTitlePhone') }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">الدولة</label>
                                    <select name="country_id" id="country_id" class="form-select" required aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.roles') }}</label>
                                    <select name="role_id" id="role_id" class="form-select" required aria-label="select example">
                                        <option value="">{{ __('dashboard.openSelect') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.image') }}
                                        (jpeg,jpg,png,gif,webp)*</label>
                                    <input id="" name="image" type="file" class="form-control"
                                        aria-label="file example">
                                    <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.validationPassword') }}</label>
                                    <input class="form-control is-invalid" id="password"
                                        placeholder="{{ __('dashboard.password') }}" name="password" type="password"
                                        pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="{{ __('dashboard.titlePassword') }}">

                                </div>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.confirmPassword') }}</label>
                                    <input class="form-control is-invalid" id="confirm_password"
                                        {{ __('dashboard.confirmPassword') }} name="password_confirmation"
                                        type="password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                        title="{{ __('dashboard.titlePassword') }}">
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
                        <h5 class="modal-title" id="deleteModal">
                            {{ __('dashboard.deleteemployee') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('embloyee.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="userIdForDelete" name="userId" type="hidden" class="form-control">
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
            function myFunction(e, id, name, phone, email, role_id, country_id, type = "") {
                if (type == "update") {
                    const e = document.getElementById('userIdForUpdate');
                    if (e) {
                        e.value = id;
                        document.getElementById('name').value = name;
                        document.getElementById('email').value = email;
                        document.getElementById('phone').value = phone;
                        document.getElementById('role_id').value = role_id;
                        document.getElementById('country_id').value = country_id;
                    }
                } else if (type == "delete") {
                    console.log(id);
                    const e = document.getElementById('userIdForDelete');
                    if (e) e.value = id;
                }
            }
            var password = document.getElementById("password"),
                confirm_password = document.getElementById("confirm_password");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("كلمة السر غير مطابقه");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            if (password) {
                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;
            }

            var passwordUpdate = document.getElementById("passwordUpdate"),
                confirm_passwordUpdate = document.getElementById("confirm_passwordUpdate");

            function validatePasswordUpdate() {
                if (passwordUpdate.value != confirm_passwordUpdate.value) {
                    confirm_passwordUpdate.setCustomValidity("كلمة السر غير مطابقه");
                } else {
                    confirm_passwordUpdate.setCustomValidity('');
                }
            }

            if (passwordUpdate) {
                passwordUpdate.onchange = validatePasswordUpdate;
                confirm_passwordUpdate.onkeyup = validatePasswordUpdate;
            }

            function hideRow(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
                    el.cells[5].remove(5)
                    el.cells[0].remove(0)
                })
                location.reload(true);
            }

            function ExportToExcel(type, fn, dl) {
                var elt = document.getElementById('user-list-table');

                hideRow(elt);
                var wb = XLSX.utils.table_to_book(elt, {
                    sheet: "sheet1"
                });
                return dl ?
                    XLSX.write(wb, {
                        bookType: type,
                        bookSST: true,
                        type: 'base64'
                    }) :

                    XLSX.writeFile(wb, fn || ('الموظفين.' + (type || 'xlsx')));
            }
        </script>
    @endsection
