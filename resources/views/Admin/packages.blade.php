@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            @if ($status == 0)
                                <h1>{{ __('dashboard.newpackages') }}</h1>
                            @endif
                            @if ($status == 1)
                                <h1>{{ __('dashboard.Accepetedpackages') }}</h1>
                            @endif
                            @if ($status == 2)
                                <h1>{{ __('dashboard.rejecetdpackages') }}</h1>
                            @endif
                            @if ($status == 3)
                                <h1>{{ __('dashboard.cancelPackages') }}</h1>
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
                                    data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>{{ __('dashboard.#') }}</th>
                                            <th>{{ __('dashboard.orderNumber') }}</th>
                                            <th>{{ __('dashboard.clientName') }}</th>
                                            <th>{{ __('dashboard.clientEmail') }}</th>
                                            <th>{{ __('dashboard.clientPhone') }}</th>
                                            <th>{{ __('dashboard.total') }}</th>
                                            <th>{{ __('dashboard.delivaryPrice') }}</th>
                                            <th>{{ __('dashboard.application_ratio') }}</th>
                                            <th>{{ __('dashboard.package_type') }}</th>
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
                                        @foreach ($packages as $key => $package)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <a onclick="getUserData(this, '{{ $package->id }}')"
                                                        href="#packageModel" data-bs-toggle="modal" data-placement="top"
                                                        title="package"
                                                        data-original-title="package">{{ $package->package_id }}</a>
                                                </td>
                                                <td>{{ $package->user->name }}</td>
                                                <td>{{ $package->user->email }}</td>
                                                <td>{{ $package->user->phone }}</td>
                                                <td>{{ $package->total }} {{ __('dashboard.Rial') }}</td>
                                                <td>{{ $package->delegate_ratio }} {{ __('dashboard.Rial') }}</td>
                                                <td>{{ $package->application_ratio }} {{ __('dashboard.Rial') }}</td>
                                                <td>{{ $package->package_type }}</td>
                                                <td>{{ $package->created_at }}</td>
                                                <td>{{ $package->date }}</td>
                                                <td>
                                                    @if ($status == 0)
                                                        <a href="{{ route('accepetPackage', $package->id) }}"
                                                            class="btn btn-success">{{ __('dashboard.Accepet') }}</a>
                                                        <a data-bs-toggle="modal" data-placement="top" title=""
                                                            data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $package->id }}', 'rejecet')"
                                                            href="#rejecetModel"
                                                            class="btn btn-danger">{{ __('dashboard.rejecet') }}</a>
                                                    @else
                                                        @if ($package->orderStatus == 'Underway')
                                                            {{ __('dashboard.orderStatus') }}
                                                        @elseif ($package->orderStatus == 'new')
                                                            {{ __('dashboard.newOrder') }}
                                                        @elseif ($package->orderStatus == 'done')
                                                            {{ __('dashboard.done') }}
                                                        @elseif ($package->orderStatus == 'Deliveryisunderway')
                                                            {{ __('dashboard.Deliveryisunderway') }}
                                                        @elseif ($package->orderStatus == 'deliverd')
                                                            {{ __('dashboard.sentdeliveredhanded') }}
                                                        @elseif ($package->orderStatus == 'throwback')
                                                            {{ __('dashboard.throwback') }}
                                                        @elseif ($package->orderStatus == 'wascanceled')
                                                            {{ __('dashboard.wascanceled') }}
                                                        @endif
                                                    @endif
                                                </td>
                                                @if ($status == 2)
                                                    <td>{{ $package->cancel_ar }}</td>
                                                    <td>{{ $package->action_name }}</td>
                                                @endif
                                                @if ($status == 3)
                                                    <td>{{ $package->cancel_ar }}</td>
                                                    <td>{{ $package->action_name }}</td>
                                                @endif
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a href="{{ route('packageData', $package->id) }}"
                                                            class="btn btn-sm btn-icon" style="background-color:#3a57e8">
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
                                                                onclick="myFunction(this, '{{ $package->id }}', 'delete')"
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
                                                            action="{{ route('packages.delete') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input id="categoryIdDelete" name="packageId" type="hidden"
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
                                                            action="{{ route('rejecetPackage') }}" method="POST">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="packageModel" tabindex="-1" aria-labelledby="packageModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="packageModel">{{ __('dashboard.packageDetial') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.#') }}</label>
                                <input class="form-control" id="id" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.address_From') }}</label>
                                <input class="form-control" id="name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea"
                                    class="form-label">{{ __('dashboard.address_To') }}</label>
                                <input class="form-control" id="useremail" readonly>
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
            function hideRow(table) {
                let rowsArray = Array.from(table.rows)
                rowsArray.forEach(function(el, i) {
                    el.cells[12].remove(12)
                    el.cells[11].remove(11)
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
                        XLSX.writeFile(wb, fn || ('الطرود الجديدة.' + (type || 'xlsx')));
                    @elseif ($status == 1)
                        XLSX.writeFile(wb, fn || ('الطرود المقبولة.' + (type || 'xlsx')));
                    @elseif ($status == 2)
                        XLSX.writeFile(wb, fn || ('الطرود المرفوضة.' + (type || 'xlsx')));
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

            function getUserData(e, id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (id) {
                    $.post("/packages/packageDetials", {
                        "id": id,
                    }, function(data, status, xhr) {
                        data = JSON.parse(data)
                        console.log(data);
                        document.getElementById("id").value = data.id;
                        document.getElementById("name").value = data.address_From;
                        document.getElementById("useremail").value = data.address_To;
                    })
                }
            }
        </script>
    @endsection
