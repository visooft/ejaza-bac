@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.editProduct') }}</h1>
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
                <div class="col-sm-12" style="margin-top: 10px;">
                    <div class="card">
                        @include('partials._session')
                        @include('partials._errors')

                        <div class="modal-body">
                            <div class="card-body col-md-8">

                                <form id="update-form" class="was-validated" action="{{ route('products.update') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="productId" value="{{ $id }}">
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.name_ar') }}</label>
                                        <input
                                            class="form-control @if (isset($product->name_ar)) is-valid @else is-invalid @endif"
                                            id="validationTextarea" placeholder="{{ __('dashboard.name_ar') }}"
                                            type="text" name="name_ar" required value="{{ $product->name_ar }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.name_en') }}</label>
                                        <input
                                            class="form-control @if (isset($product->name_en)) is-valid @else is-invalid @endif"
                                            id="validationTextarea" placeholder="{{ __('dashboard.name_en') }}"
                                            type="text" name="name_en" required value="{{ $product->name_en }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.desc_ar') }}</label>
                                        <textarea name="desc_ar" class="form-control @if (isset($product->desc_ar)) is-valid @else is-invalid @endif"
                                            id="validationTextarea" cols="30" rows="3" required placeholder="{{ __('dashboard.desc_ar') }}">{{ $product->desc_ar }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.desc_en') }}</label>
                                        <textarea name="desc_en" class="form-control @if (isset($product->desc_en)) is-valid @else is-invalid @endif"
                                            id="validationTextarea" cols="30" rows="3" required placeholder="{{ __('dashboard.desc_en') }}">{{ $product->desc_en }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationTextarea" class="form-label">{{ __('dashboard.offer') }}
                                            %</label>
                                        <input class="form-control is-invalid" id="validationTextarea"
                                            placeholder="{{ __('dashboard.offer') }}" type="number" min="0"
                                            max="100" step="0.01" name="offer" value="{{ $product->offer }}">
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked">{{ __('dashboard.additionsQuestions') }}</label>
                                            <input class="form-check-input" type="checkbox" name="additionsQuestions"
                                                id="additionsQuestions"
                                                @if (count($product->detials) > 0) {{ 'checked' }} @endif
                                                onclick='handleClick(this);'>
                                        </div>
                                    </div>
                                    <div style="display: none" id="siveCheck" class="form-group">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked">{{ __('dashboard.siveCheck') }}</label>
                                            <input class="form-check-input" type="checkbox" name="siveCheck"
                                                id="siveCheckClick"
                                                @if (count($product->detials) > 0) {{ 'checked' }} @endif
                                                onclick='handleClickSize(this);'>
                                        </div>
                                    </div>
                                    <div style="display: none" id="colorCheck" class="form-group">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked">{{ __('dashboard.colorCheck') }}</label>
                                            <input class="form-check-input" type="checkbox" name="colorCheckClick"
                                                id="colorCheckClick"
                                                @if (count($product->colorDetials) > 0) {{ 'checked' }} @endif
                                                onclick='handleClickColor(this);'>
                                        </div>
                                    </div>
                                    <div style="display: none" id="additionCheck" class="form-group">
                                        <div class="mb-3 form-check form-switch">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked">{{ __('dashboard.additionCheck') }}</label>
                                            <input class="form-check-input" type="checkbox" name="additionCheckClick"
                                                id="additionCheckClick"
                                                @if (count($product->additionsDetials) > 0) {{ 'checked' }} @endif
                                                onclick='handleClickAddition(this);'>
                                        </div>
                                    </div>
                                    <div style="display: none" id="sizeDiv" class="form-group">
                                        <div style="display: none" id="sizeRequired" class="form-group">
                                            <div class="mb-3 form-check form-switch">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked">{{ __('dashboard.sizeRequired') }}</label>
                                                <input class="form-check-input" type="checkbox" name="sizeRequired"
                                                    @if (isset($product->sizeType) && $product->sizeType == 1) {{ 'checked' }} @endif
                                                    id="sizeRequiredCheck">
                                            </div>
                                        </div>
                                        @foreach ($product->detials as $size)
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.size') }}</label>
                                            <select name="size[]" id="sizeSelecet" class="form-select"
                                                aria-label="select example">
                                                @foreach ($sizes as $sizeData)
                                                    <option @if ($sizeData->id == $size->size_id) {{ 'selected' }} @endif
                                                        value="{{ $sizeData->id }}">{{ $sizeData->name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                            <div class="form-group">
                                                <label for="validationTextarea"
                                                    class="form-label">{{ __('dashboard.price') }}</label>
                                                <input class="form-control is-invalid" id="priceSize"
                                                    placeholder="{{ __('dashboard.price') }}" type="number"
                                                    min="0" step="0.000001" name="price[]"
                                                    value="{{ $size->price }}">
                                            </div>
                                        @endforeach

                                        <div id="new_chq"></div>

                                        <div class="btn btn-success" onclick="add(this)">{{ __('dashboard.addsize') }}
                                        </div>
                                        <div class="btn btn-danger" onclick="remove(this)">{{ __('dashboard.delete') }}
                                        </div>
                                        <input type="hidden" value="1" id="total_chq">
                                    </div>

                                    <div style="display: none" id="colorDiv" class="form-group">
                                        <div style="display: none" id="colorRequired" class="form-group">
                                            <div class="mb-3 form-check form-switch">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked">{{ __('dashboard.colorRequired') }}</label>
                                                <input class="form-check-input" type="checkbox" name="colorRequired"
                                                    id="colorRequiredCheck"
                                                    @if (isset($product->colorType) && $product->colorType == 1) {{ 'checked' }} @endif>
                                            </div>
                                        </div>
                                        @foreach ($product->colorDetials as $color)
                                            <label for="validationTextarea"
                                                class="form-label">{{ __('dashboard.color') }}</label>
                                            <select name="color[]" id="colorSelecet" class="form-select"
                                                aria-label="select example">
                                                <option value="">{{ __('dashboard.openSelect') }}</option>
                                                @foreach ($data as $colorData)
                                                    <option @if ($colorData->id == $color->color_data_id) {{ 'selected' }} @endif
                                                        style="background-color:{{ $colorData->code }}"
                                                        value="{{ $colorData->id }}">{{ $colorData->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                            <div class="form-group">
                                                <label for="validationTextarea"
                                                    class="form-label">{{ __('dashboard.price') }}</label>
                                                <input class="form-control is-invalid" id="priceColor"
                                                    placeholder="{{ __('dashboard.price') }}" type="number"
                                                    min="0" step="0.000001" name="priceColor[]"
                                                    value="{{ $color->price }}">
                                            </div>
                                        @endforeach

                                        <div id="new_chqColor"></div>

                                        <div class="btn btn-success" onclick="addColor(this)">
                                            {{ __('dashboard.addColor') }}</div>
                                        <div class="btn btn-danger" onclick="removeColor(this)">
                                            {{ __('dashboard.delete') }}</div>
                                        <input type="hidden" value="1" id="total_chq_color">
                                    </div>

                                    <div style="display: none" id="additionDiv" class="form-group">
                                        <div style="display: none" id="additionRequired" class="form-group">
                                            <div class="mb-3 form-check form-switch">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked">{{ __('dashboard.additionRequired') }}</label>
                                                <input class="form-check-input" type="checkbox" name="additionRequired"
                                                    id="additionRequiredCheck"
                                                    @if (isset($product->additionType) && $product->additionType == 1) {{ 'checked' }} @endif>
                                            </div>
                                        </div>
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.additions') }}</label>
                                        @foreach ($product->additionsDetials as $detial)
                                            <select name="additions[]" id="additionsSelecet" class="form-select"
                                                aria-label="select example"
                                                onclick="getAdditionsupdate(additionsSelecet)">
                                                @foreach ($additions as $add)
                                                    <option
                                                        @if ($detial->addition_id == $add->id) value="{{ $detial->addition_id }}" @else value="{{ $add->id }}" @endif>
                                                        {{ $add->name }}</option>
                                                @endforeach
                                            </select>
                                            <label id="additionsDetials" for="validationTextarea"
                                                class="form-label">{{ __('dashboard.additionsDetials') }}</label>
                                            <select name="additionsDetials[]" id="additionsDetialsSelecetupdate"
                                                class="form-select" aria-label="select example">
                                                @foreach ($detial->additions as $addition)
                                                    <option
                                                        @if ($detial->additions_detials_id == $addition->id) value="{{ $detial->additions_detials_id }}" @else value="{{ $addition->id }}" @endif>
                                                        {{ $addition->name_ar }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-group">
                                                <label for="validationTextarea"
                                                    class="form-label">{{ __('dashboard.price') }}</label>
                                                <input class="form-control is-invalid" id="priceadd"
                                                    placeholder="{{ __('dashboard.price') }}" type="number"
                                                    min="0" step="0.000001" name="priceadd[]"
                                                    value="{{ $detial->price }}">
                                            </div>
                                        @endforeach


                                    </div>
                                    <div class="form-group" id="additionAction" style="display: none">

                                        <div id="new_chqAddition2"></div>

                                    </div>
                                    <div class="btn btn-success" onclick="addAddition(this)">
                                        {{ __('dashboard.addAdditions') }}</div>
                                    <div class="btn btn-danger" onclick="removeAddition(this)">
                                        {{ __('dashboard.delete') }}</div>
                                    <input type="hidden" value="1" id="total_chq_Addition">
                                    <div class="form-group" id="sellerOne">
                                        <label for="validationTextarea"
                                            class="form-label">{{ __('dashboard.price') }}</label>
                                        <input required class="form-control is-invalid" id="priceOne"
                                            placeholder="{{ __('dashboard.price') }}" type="number" min="0"
                                            step="0.000001" name="priceOne" value="{{ $product->price }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="validationTextarea" class="form-label">{{ __('dashboard.image') }}
                                            (jpeg,jpg,png,gif,webp)*</label>
                                        <input name="image" type="file" class="form-control"
                                            aria-label="file example">
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
        </div>
        <br><br>
        <script>
            // addition click
            if (document.getElementById('additionsQuestions').checked) {
                document.getElementById('siveCheck').style.display = 'block';
                document.getElementById('colorCheck').style.display = 'block';
                document.getElementById('additionCheck').style.display = 'block';
                document.getElementById('priceOne').required = false;
            } else {
                document.getElementById('siveCheck').style.display = 'none';
                document.getElementById('colorCheck').style.display = 'none';
                document.getElementById('additionCheck').style.display = 'none';
                document.getElementById('priceOne').required = true;
            }

            // size click

            if (document.getElementById('siveCheckClick').checked) {
                document.getElementById('sizeRequired').style.display = 'block';
                document.getElementById('sizeDiv').style.display = 'block';
                document.getElementById('priceSize').required = true;
                document.getElementById('sizeSelecet').required = true;
            } else {
                document.getElementById('sizeRequired').style.display = 'none';
                document.getElementById('sizeDiv').style.display = 'none';
                document.getElementById('priceSize').required = false;
                document.getElementById('sizeSelecet').required = false;
                document.getElementById('sizeRequiredCheck').required = false;
                document.getElementById('sizeRequiredCheck').checked = false;
            }

            // color click

            if (document.getElementById('colorCheckClick').checked) {
                document.getElementById('colorRequired').style.display = 'block';
                document.getElementById('colorDiv').style.display = 'block';
                document.getElementById('priceColor').required = true;
                document.getElementById('colorSelecet').required = true;
            } else {
                document.getElementById('colorRequired').style.display = 'none';
                document.getElementById('colorDiv').style.display = 'none';
                document.getElementById('priceColor').required = false;
                document.getElementById('colorSelecet').required = false;
                document.getElementById('colorRequiredCheck').required = false;
            }

            // addition click

            if (document.getElementById('additionCheckClick').checked) {
                document.getElementById('additionDiv').style.display = 'block';
                document.getElementById('additionRequired').style.display = 'block';
                document.getElementById('additionsSelecet').required = true;
            } else {
                document.getElementById('additionDiv').style.display = 'none';
                document.getElementById('additionRequired').style.display = 'none';
                document.getElementById('additionAction').style.display = 'none';
                document.getElementById('additionsSelecet').required = false;
                document.getElementById("additionsDetialsSelecet").required = false
                document.getElementById("priceadd").required = false
                document.getElementById('additionRequiredCheck').required = false;
            }


            // finction click
            function handleClick(cb) {
                if (cb.checked) {
                    document.getElementById('siveCheck').style.display = 'block';
                    document.getElementById('colorCheck').style.display = 'block';
                    document.getElementById('additionCheck').style.display = 'block';
                    document.getElementById('priceOne').required = false;
                } else {
                    document.getElementById('siveCheck').style.display = 'none';
                    document.getElementById('colorCheck').style.display = 'none';
                    document.getElementById('additionCheck').style.display = 'none';
                    document.getElementById('priceOne').required = true;
                }
            }

            // function size click
            function handleClickSize(cb) {
                if (cb.checked) {
                    document.getElementById('sizeRequired').style.display = 'block';
                    document.getElementById('sizeDiv').style.display = 'block';
                    document.getElementById('priceSize').required = true;
                    document.getElementById('sizeSelecet').required = true;
                } else {
                    document.getElementById('sizeRequired').style.display = 'none';
                    document.getElementById('sizeDiv').style.display = 'none';
                    document.getElementById('priceSize').required = false;
                    document.getElementById('sizeSelecet').required = false;
                    document.getElementById('sizeRequiredCheck').required = false;
                    document.getElementById('sizeRequiredCheck').checked = false;

                }
            }

            // function color click
            function handleClickColor(cb) {
                if (cb.checked) {
                    document.getElementById('colorRequired').style.display = 'block';
                    document.getElementById('colorDiv').style.display = 'block';
                    document.getElementById('priceColor').required = true;
                    document.getElementById('colorSelecet').required = true;
                } else {
                    document.getElementById('colorRequired').style.display = 'none';
                    document.getElementById('colorDiv').style.display = 'none';
                    document.getElementById('priceColor').required = false;
                    document.getElementById('colorSelecet').required = false;
                    document.getElementById('colorRequiredCheck').required = false;
                }
            }


            // function addition click
            function handleClickAddition(cb) {
                if (cb.checked) {
                    document.getElementById('additionDiv').style.display = 'block';
                    document.getElementById('additionRequired').style.display = 'block';
                    document.getElementById('additionsSelecet').required = true;
                } else {
                    document.getElementById('additionDiv').style.display = 'none';
                    document.getElementById('additionRequired').style.display = 'none';
                    document.getElementById('additionAction').style.display = 'none';
                    document.getElementById('additionsSelecet').required = false;
                    document.getElementById("additionsDetialsSelecet").required = false
                    document.getElementById("priceadd").required = false
                    document.getElementById('additionRequiredCheck').required = false;
                }
            }


            function add(e) {
                var new_chq_no = parseInt($('#total_chq').val()) + 1;
                var newDiv = `<div class="form-group" id='new_${new_chq_no}'>
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.size') }}</label>
                                <select required name="size[]" class="form-select" aria-label="select example">
                                    <option value="">{{ __('dashboard.openSelect') }}</option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.price') }}</label>
                                    <input required class="form-control is-invalid" id="validationTextarea" placeholder="{{ __('dashboard.price') }}" type="number" min="0" step="0.000001" name="price[]">
                                </div>
                            </div>`;
                $('#new_chq').append(newDiv);
                $('#total_chq').val(new_chq_no)
            }

            function remove(e) {
                var last_chq_no = $('#total_chq').val();
                if (last_chq_no > 1) {
                    $('#new_' + last_chq_no).remove();
                    $('#total_chq').val(last_chq_no - 1);
                }

            }

            function addColor(e) {
                var new_chq_no = parseInt($('#total_chq_color').val()) + 1;
                var newDiv = `<div class="form-group" id='new_2${new_chq_no}'>
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.color') }}</label>
                                <select required name="color[]" class="form-select" aria-label="select example">
                                    <option value="">{{ __('dashboard.openSelect') }}</option>
                                    @foreach ($data as $color)
                                    <option style='background-color:{{ $color->code }}' value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                                <div class="form-group">
                                    <label for="validationTextarea" class="form-label">{{ __('dashboard.price') }}</label>
                                    <input required class="form-control is-invalid" id="validationTextarea" placeholder="{{ __('dashboard.price') }}" type="number" min="0" step="0.000001" name="priceColor[]">
                                </div>
                            </div>`;
                $('#new_chqColor').append(newDiv);
                $('#total_chq_color').val(new_chq_no)

            }

            function removeColor(e) {
                var last_chq_no = $('#total_chq_color').val();
                if (last_chq_no > 1) {
                    $('#new_2' + last_chq_no).remove();
                    $('#total_chq_color').val(last_chq_no - 1);
                }

            }

            function addAddition(e) {
                document.getElementById("additionAction").style.display = "block";
                var new_chq_no = parseInt($('#total_chq_Addition').val()) + 1;
                var newDiv = `<div class="form-group" id='new_3${new_chq_no}'>
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.additions') }}</label>
                                <select required name="additions[]" id="additionsId${new_chq_no}" class="form-select" aria-label="select example" onclick="getAdditions2(this)">
                                    <option value="">{{ __('dashboard.openSelect') }}</option>
                                    @foreach ($additions as $add)
                                    <option value="{{ $add->id }}">{{ $add->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('dashboard.validationImage') }}</div>
                            </div>
                            <div class="form-group" id="additionAction2${new_chq_no}">
                                <label id="additionsDetials" for="validationTextarea"
                                    class="form-label">{{ __('dashboard.additionsDetials') }}</label>
                                <select name="additionsDetials[]" id="additionsDetialsSelecet2${new_chq_no}"
                                    class="form-select" aria-label="select example" required>
                                </select>
                                <div class="form-group">
                                    <label for="validationTextarea"
                                        class="form-label">{{ __('dashboard.price') }}</label>
                                    <input class="form-control is-invalid" id="priceadd2${new_chq_no}"
                                        placeholder="{{ __('dashboard.price') }}" type="number"
                                        min="0" step="0.000001" name="priceadd[]" required>
                                </div>
                            </div>`;
                $('#new_chqAddition2').append(newDiv);
                $('#total_chq_Addition').val(new_chq_no)
            }

            function removeAddition(e) {
                var last_chq_no = $('#total_chq_Addition').val();
                if (last_chq_no > 1) {
                    $('#new_3' + last_chq_no).remove();
                    $('#additionAction2' + last_chq_no).remove();
                    $('#total_chq_Addition').val(last_chq_no - 1);
                }

            }

            function getAdditionsupdate(additionsSelecet) {
                let cityDiv = document.getElementById("additionsDetialsSelecetupdate")
                cityDiv.innerHTML = ""
                additionsSelecet = parseInt(additionsSelecet.value)
                additionsSelecet = isNaN(additionsSelecet) ? -1 : additionsSelecet
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (additionsSelecet) {
                    $.post("/productStore/getAdditionsData", {
                        "id": additionsSelecet,
                    }, function(data, status, xhr) {
                        data = JSON.parse(data)
                        if (data.length > 0) {
                            if (Array.isArray(data)) {
                                document.getElementById("additionsDetialsSelecetupdate").required = true
                                document.getElementById("priceadd").required = true
                                if (cityDiv != null) {
                                    data.forEach(function(city, i) {
                                        cityDiv.innerHTML += `
                                        <option value="${city.id}">${city.name}</option>
                                        `
                                    })
                                }
                            }
                        }

                    })
                }
            }

            function getAdditions2(additionsSelecet) {
                var last_chq_no = $('#total_chq_Addition').val();
                let cityDiv = document.getElementById("additionsDetialsSelecet2" + last_chq_no)
                cityDiv.innerHTML = ""
                additionsSelecet = parseInt(additionsSelecet.value)
                console.log(additionsSelecet);
                additionsSelecet = isNaN(additionsSelecet) ? -1 : additionsSelecet
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (additionsSelecet) {
                    $.post("/productStore/getAdditionsData", {
                        "id": additionsSelecet,
                    }, function(data, status, xhr) {
                        data = JSON.parse(data)
                        if (data.length > 0) {
                            if (Array.isArray(data)) {
                                document.getElementById("additionAction2" + last_chq_no).style.display = "block"
                                document.getElementById("additionsDetialsSelecet2" + last_chq_no).required = true
                                document.getElementById("priceadd2" + last_chq_no).required = true
                                if (cityDiv != null) {
                                    data.forEach(function(city, i) {
                                        cityDiv.innerHTML += `
                                        <option value="${city.id}">${city.name}</option>
                                        `
                                    })
                                }
                            }
                        }

                    })
                }
            }
        </script>
    @endsection
