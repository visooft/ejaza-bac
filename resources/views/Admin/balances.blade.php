@extends('adminLayout')

@section('main')
    <!-- Nav Header Component Start -->
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1> {{ __('dashboard.newBalanceRequest') }}</h1>
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
    <!--Nav End-->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            @include('partials._session')
            @include('partials._errors')
            <div class="card-header d-inline justify-content-center">
                <div class="d-flex">
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

            <div class="card-body px-0">
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                        <thead>
                            <tr class="ligth">
                                <th>{{ __('dashboard.#') }}</th>
                                <th>{{ __('dashboard.orderNumber') }}</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.bankNumber') }}</th>
                                <th>{{ __('dashboard.IBAN') }}</th>
                                <th>{{ __('dashboard.accountNumber') }}</th>
                                <th>{{ __('dashboard.bankName') }}</th>
                                <th>{{ __('dashboard.email') }}</th>
                                <th>{{ __('dashboard.phone') }}</th>
                                <th>{{ __('dashboard.totalRequest') }}</th>
                                <th>{{ __('dashboard.time') }}</th>
                                <th>{{ __('dashboard.date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newBalances as $key => $balance)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a
                                            href="{{ route('balance', $balance->user_id) }}">{{ $balance->orderNumber }}</a>
                                    </td>
                                    <td>{{ $balance->name }}</td>
                                    <td>{{ $balance->bankNumber }}</td>
                                    <td>{{ $balance->IBAN }}</td>
                                    <td>{{ $balance->accountNumber }}</td>
                                    <td>{{ $balance->bankName }}</td>
                                    <td>{{ $balance->user->email }}</td>
                                    <td>{{ $balance->user->phone }}</td>
                                    <td>{{ $balance->total }} {{ __('dashboard.Rial') }}</td>
                                    <td>{{ $balance->created_at }}</td>
                                    <td>{{ $balance->date }}</td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#exampleModalDefault"
                                            href="#exampleModalDefault"
                                            onclick="myFunction(this, '{{ $balance->id }}' ,'update')"
                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                        <a href="{{ route('rejecetBalance', $balance->id) }}"
                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                    </td>
                                    <td>
                                        <div class="flex align-items-center list-user-action">

                                            <a class="btn btn-sm btn-icon" style="background-color:#3a57e8"
                                                href="{{ route('balance', $balance->user_id) }}">
                                                <span class="btn-inner">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                    </svg>
                                                </span>
                                            </a>
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
    <div class="modal fade" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('dashboard.accepetBalance') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submit-form" class="was-validated" action="{{ route('accapetBalance') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="balanceId" id="balanceId">
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
                        class="btn btn-primary">{{ __('dashboard.Accepet') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function myFunction(e, id, type = "") {
        if (type == "update") {
            const e = document.getElementById('balanceId');
            if (e) {
                e.value = id;
            }
        }
    }

    function hideRow(table) {
        let rowsArray = Array.from(table.rows)
        location.reload(true);

    }

    let mobile = document.querySelector('h1');

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
            XLSX.writeFile(wb, fn || (`طلبات سحب الرصيد.` + (type || 'xlsx')));
    }
</script>
