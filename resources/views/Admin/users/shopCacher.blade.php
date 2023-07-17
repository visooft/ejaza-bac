@extends('adminLayout')

@section('cs')
@endsection

@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ $shop->name }}</h1>
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
                                            <th>{{ __('dashboard.shop') }}</th>
                                            <th>{{ __('dashboard.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cachers as $cacher)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($cacher->image)
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ asset('Admin/images/cachers/' . $cacher->image) }}"
                                                            alt="{{ $cacher->name }}">
                                                    @else
                                                        <img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                            src="{{ asset('Admin/assets/images/avatars/01.png') }}"
                                                            alt="{{ $cacher->name }}">
                                                    @endif
                                                </td>
                                                <td><a
                                                        href="{{ route('getDeliveryProfile', $cacher->user_id) }}">{{ $cacher->name }}</a>
                                                </td>
                                                <td>{{ $cacher->email }}</td>
                                                <td>{{ $cacher->phone }}</td>
                                                <td><a
                                                        href="{{ route('getStoreCacher', $shop->id) }}">{{ $cacher->shopName }}</a>
                                                </td>
                                                <td>{{ $cacher->created_at }}</td>
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

        <script>
            function hideRow(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
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

                    XLSX.writeFile(wb, fn || ('الكاشير.' + (type || 'xlsx')));
            }
        </script>
    @endsection
