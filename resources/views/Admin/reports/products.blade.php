@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.products') }}</h1>
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
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>{{ __('dashboard.#') }}</th>
                                        <th>{{ __('dashboard.image') }}</th>
                                        <th>{{ __('dashboard.name') }}</th>
                                        <th>{{ __('dashboard.countItems') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-center"><img
                                                    class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                    src="{{ $product->image }}" alt="Category"></td>
                                            <td><a href="#senderModel{{ $product->id }}" data-bs-toggle="modal"
                                                    data-placement="top" title="sender"
                                                    data-original-title="sender">{{ $product->name }}</a></td>
                                            <td>{{ $product->count }} </td>
                                        </tr>
                                        <div class="modal fade" id="senderModel{{ $product->id }}" tabindex="-1"
                                            aria-labelledby="senderModel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="senderModel">
                                                            {{ __('dashboard.productDetials') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            @php
                                                                $productDetials = \App\Models\ProductDetials::where('product_id', $product->id)->get();
                                                            @endphp
                                                            @foreach ($productDetials as $data)
                                                                @php
                                                                    $size = \App\Models\Size::find($data->size_id);
                                                                    if (app()->getLocale() == 'ar') {
                                                                        $name = $size->name_ar;
                                                                    } else {
                                                                        $name = $size->name_en;
                                                                    }
                                                                @endphp
                                                                <div class="form-group">
                                                                    <label for="validationTextarea"
                                                                        class="form-label">{{ __('dashboard.size') }}</label>
                                                                    <input class="form-control"
                                                                        value="{{ $name }}
                                                                "
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="validationTextarea"
                                                                        class="form-label">{{ __('dashboard.price') }}</label>
                                                                    <input class="form-control" value="{{ $data->price }}"
                                                                        readonly>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
