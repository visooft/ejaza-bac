@extends('adminLayout')

@section('main')
    <!-- Nav Header Component Start -->
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1> {{ __('dashboard.wallet') }}</h1>
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
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-01" class="text-center" data-min-value="0"
                                            data-max-value="100" data-value="90" data-type="percent">
                                            <img width="50px" src="{{ asset('Admin\images\wallet-svgrepo-com.svg') }}">
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">{{ __('dashboard.wallet') }}</p>
                                            <h4 class="counter">{{ $delivery->wallet }} {{ __('dashboard.Rial') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="swiper-button swiper-button-next"></div>
                        <div class="swiper-button swiper-button-prev"></div>
                    </div>
                </div>
            </div>
            {{-- @include('partials._logo')
            @include('partials._errors')
            @if ($delivery->role->name == 'Delivary')
                <div style="padding: 20px">
                    <form id="logo-form" class="was-validated" action="{{ route('addtransactions') }}" method="POST">
                        @csrf
                        <input type="hidden" name="deliaryId" value="{{ $id }}">
                        <div class="form-group col-md-8">
                            <label for="validationTextarea" style="font-size: 20px"
                                class="form-label"><b>{{ __('dashboard.addWallet') }}</b></label>
                            <input type="number" min="0" name="walletvalue" id="walletvalue"
                                class="form-control is-invalid" placeholder="{{ __('dashboard.addWallet') }}">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button form="logo-form" type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
                    </div>
                </div>
            @endif --}}
            {{-- @if ($delivery->role->name == 'User')
                <div style="padding: 20px">
                    <form id="logo-form" class="was-validated" action="{{ route('addWallet') }}" method="POST">
                        @csrf
                        <input type="hidden" name="userId" value="{{ $id }}">
                        <div class="form-group col-md-8">
                            <label for="validationTextarea" style="font-size: 20px"
                                class="form-label"><b>{{ __('dashboard.addWallet') }}</b></label>
                            <input type="number" min="0" name="walletvalue" id="walletvalue"
                                class="form-control is-invalid" placeholder="{{ __('dashboard.addWallet') }}">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button form="logo-form" type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
                    </div>
                </div>
            @endif --}}
            @if ($delivery->role->name == 'Delivary')
                <div class="card-header d-inline justify-content-center">
                    <div class="d-flex">
                        @can('superAdmin')
                            <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                <button type="button" class="btn btn-primary">
                                    {{ __('dashboard.additionsMoney') }}
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

                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                            <thead>
                                <tr class="ligth">
                                    <th>{{ __('dashboard.#') }}</th>
                                    <th>{{ __('dashboard.total') }}</th>
                                    <th>{{ __('dashboard.time') }}</th>
                                    <th>{{ __('dashboard.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($additions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $transaction->total }} {{ __('dashboard.Rial') }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-header d-inline justify-content-center">
                    <div class="d-flex">
                        @can('superAdmin')
                            <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                <button type="button" class="btn btn-primary">
                                    {{ __('dashboard.exportsMoney') }}
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

                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                            <thead>
                                <tr class="ligth">
                                    <th>{{ __('dashboard.#') }}</th>
                                    <th>{{ __('dashboard.total') }}</th>
                                    <th>{{ __('dashboard.time') }}</th>
                                    <th>{{ __('dashboard.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exports as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $transaction->total }} {{ __('dashboard.Rial') }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if ($delivery->role->name == 'User')
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                            <thead>
                                <tr class="ligth">
                                    <th>{{ __('dashboard.#') }}</th>
                                    <th>{{ __('dashboard.walletId') }}</th>
                                    <th>{{ __('dashboard.total') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.time') }}</th>
                                    <th>{{ __('dashboard.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wallets as $key => $wallet)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $wallet->walletId }}</td>
                                        <td>{{ $wallet->Financial_additions }} {{ __('dashboard.Rial') }}</td>
                                        <td>
                                            @if ($wallet->type == 'exports')
                                                {{ __('dashboard.exports') }}
                                            @elseif ($wallet->type == 'throwback')
                                                {{ __('dashboard.throwback') }}
                                            @endif
                                        </td>
                                        <td>{{ $wallet->created_at }}</td>
                                        <td>{{ $wallet->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
<script>
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
            XLSX.writeFile(wb, fn || (`{{ $delivery->name }}.` + (type || 'xlsx')));
    }
</script>
