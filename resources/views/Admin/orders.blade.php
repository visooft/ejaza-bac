@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            @if ($status == 0)
                                <h1>{{ __('dashboard.newOrders') }}</h1>
                            @endif
                            @if ($status == 1)
                                <h1>{{ __('dashboard.AccepetedOrders') }}</h1>
                            @endif
                            @if ($status == 2)
                                <h1>{{ __('dashboard.rejecetdOrders') }}</h1>
                            @endif
                            @if ($status == 3)
                                <h1>{{ __('dashboard.cancelOrders') }}</h1>
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
                        @include('partials._session')
                        @include('partials._errors')
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid"
                                    >
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.#') }}</th>
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.orderNumber') }}</th>
                                            <th>{{ __('dashboard.clientName') }}</th>
                                            <th>{{ __('dashboard.clientEmail') }}</th>
                                            <th>{{ __('dashboard.clientPhone') }}</th>
                                            <th>{{ __('dashboard.from') }}</th>
                                            <th>{{ __('dashboard.to') }}</th>
                                            <th>{{ __('dashboard.count') }}</th>
                                            <th>{{ __('dashboard.price') }}</th>
                                            <th>{{ __('dashboard.time') }}</th>
                                            <th>{{ __('dashboard.date') }}</th>
                                            <th>{{ __('dashboard.status') }}</th>
                                            @if ($status == 2)
                                                <th>{{ __('dashboard.reason') }}</th>
                                                <th>{{ __('dashboard.whoRejecet') }}</th>
                                            @endif
                                            @if ($status == 3)
                                                <th>{{ __('dashboard.reasonDelete') }}</th>
                                                <th>{{ __('dashboard.whoDelete') }}</th>
                                            @endif

                                            <th>{{ __('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center"><img
                                                        class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                        src="{{ asset($order->image) }}" alt="Category"></td>
                                                <td><a
                                                        href="{{ route('orderDetials', $order->id) }}">{{ $order->orderNumber }}</a>
                                                </td>

                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->user->email }}</td>
                                                <td>{{ $order->user->phone }}</td>
                                                <td>{{ $order->from }}</td>
                                                <td>{{ $order->to}}</td>
                                                <td>{{ $order->count}}</td>
                                                <td>{{ $order->total }} {{ __('dashboard.Rial') }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->date }}</td>
                                                <td>
                                                    @if ($status == 0)
                                                        <a href="{{ route('accepetOrder', $order->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                                        <a data-bs-toggle="modal" data-placement="top" title=""
                                                            data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $order->id }}', 'rejecet')"
                                                            href="#rejecetModel"
                                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                                    @else
                                                        @if ($order->status == 1)
                                                            تم الموافقة
                                                        @endif
                                                        @if ($order->status == 2)
                                                            تم الرفض
                                                        @endif
                                                        @if ($order->status == 3)
                                                            تم الالغاء
                                                        @endif
                                                    @endif
                                                </td>
                                                @if ($status == 2)
                                                    <td>{{ $order->cancel_ar }}</td>
                                                    <td>{{ $order->action_name }}</td>
                                                @endif
                                                @if ($status == 3)
                                                    <td>{{ $order->cancel_ar }}</td>
                                                    <td>{{ $order->action_name }}</td>
                                                @endif
                                                <td>
                                                    <div class="flex align-items-center list-user-action">

                                                        <a class="btn btn-sm btn-icon" style="background-color:#3a57e8"
                                                            href="{{ route('orderDetials', $order->id) }}">
                                                            <span class="btn-inner">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        @if ($status == 0)
                                                            <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                                data-placement="top" title=""
                                                                data-original-title="Delete"
                                                                onclick="myFunction(this, '{{ $order->id }}', 'delete')"
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
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <div class="modal fade" id="deleteModal" tabindex="-1"
                                            aria-labelledby="deleteModal" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModal">
                                                            {{ __('dashboard.deleteOrder') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="card-body">
                                                        <form id="delete-form" class="was-validated"
                                                            action="{{ route('orders.delete') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input id="categoryIdDelete" name="orderId" type="hidden"
                                                                class="form-control">
                                                            <div class="form-group">
                                                                <label for="validationTextarea"
                                                                    class="form-label">{{ __('dashboard.reasonDelete') }}</label>
                                                                <textarea name="reason" class="form-control" id="reason" cols="30" rows="3" required
                                                                    placeholder="{{ __('dashboard.reasonDelete') }}"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                                                        <button form="delete-form" type="submit"
                                                            class="btn btn-primary">{{ __('dashboard.delete') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="rejecetModel" tabindex="-1"
                                            aria-labelledby="rejecetModel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejecetModel">
                                                            {{ __('dashboard.rejecetOrderAction') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="card-body">
                                                        <form id="rejecet-form" class="was-validated"
                                                            action="{{ route('rejecetOrder') }}" method="POST">
                                                            @csrf
                                                            <input id="categoryIdrejecet" name="orderId" type="hidden"
                                                                class="form-control">
                                                            <div class="form-group">
                                                                <label for="validationTextarea"
                                                                    class="form-label">{{ __('dashboard.reason') }}</label>
                                                                <textarea name="reason" class="form-control" id="reason" cols="30" rows="3" required
                                                                    placeholder="{{ __('dashboard.reason') }}"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                                                        <button form="rejecet-form" type="submit"
                                                            class="btn btn-primary">{{ __('dashboard.rejecet') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tbody>
                                </table>
                                <div>
                                    {{ $orders->links() }}
                                </div>

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
                    el.cells[10].remove(10)
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
                    @if ($status == 0)
                        XLSX.writeFile(wb, fn || ('الطلبات الجديدة.' + (type || 'xlsx')));
                    @elseif ($status == 1)
                        XLSX.writeFile(wb, fn || ('الطلبات المقبولة.' + (type || 'xlsx')));
                    @elseif ($status == 2)
                        XLSX.writeFile(wb, fn || ('الطلبات المرفوضة.' + (type || 'xlsx')));
                    @endif
            }

            function myFunction(e, id, type = "") {
                if (type == "delete") {
                    const e = document.getElementById('categoryIdDelete');
                    if (e) e.value = id;
                } else if (type == "rejecet") {
                    const e = document.getElementById('categoryIdrejecet');
                    if (e) e.value = id;
                }
            }
        </script>
    @endsection
