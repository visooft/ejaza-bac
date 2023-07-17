@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.editRole') }}</h1>
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
                <div class="col-sm-12" style="margin-top: 10px">
                    <div class="card">
                        @include('partials._session')
                        @include('partials._errors')

                        <div class="modal-body">
                            <div class="card-body">

                                <form id="role-form" class="was-validated" action="{{ route('role.update') }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="roleId" value="{{ $role->id }}">
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.name') }}</label>
                                        <input class="form-control" placeholder="اسم الدور"
                                            value="
                                {{ $role->name }}" type="text"
                                            name="name" @if ($role->name == 'User' || $role->name == 'super Admin') readonly @endif>

                                    </div>
                                    <?php
                                    $permissions = json_decode($role->permissions);
                                    ?>
                                    <div class="form-group mb-0">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.permissions') }}</label>
                                        <br>
                                        @foreach (config('global_ar.premissions') as $name => $value)
                                            <label class="checkbox-inline">
                                                @if ($name != 'merchant')
                                                    <input type="checkbox" class="chk-box" name="permissions[]"
                                                        value="{{ $name }}"
                                                        {{ in_array($name, $permissions) ? 'checked' : '' }}>
                                                    {{ $value }}
                                                @endif

                                            </label>
                                            <br>
                                        @endforeach


                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                            <button form="role-form" type="submit"
                                class="btn btn-primary">{{ __('dashboard.save') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br><br>
    @endsection
