<div class="col-md-6 order-md-1 order-2 align-self-center">
    <form wire:submit.prevent="registerResturant">
        @csrf
        <div class="upload-immg">

            <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" class="upload__inputfile" required name="logo">
            <label for="imageUpload" class="col-md-12">
                <div class="avatar-upload col-md-12">
                    <div class="avatar-preview profile-preview d-inline-block"
                        style=" background-image: url({{ asset('Web/images/camera.png') }})">
                        <div id="imagePreview">
                        </div>
                    </div>
                    <div class="short-details d-inline-block">
                        <span class="d-block">{{ __('web.title') }}
                        </span>
                    </div>
                </div>
            </label>
            <input type="file" id="imageUpload2" accept=".png, .jpg, .jpeg" class="upload__inputfile" required name="backGround">
            <label for="imageUpload2" class="col-md-12">
                <div class="avatar-upload col-md-12">
                    <div class="avatar-preview profile-preview d-inline-block"
                        style=" background-image: url({{ asset('Web/images/camera.png') }})">
                        <div id="imagePreview2">
                        </div>
                    </div>
                    <div class="short-details d-inline-block">
                        <span class="d-block">{{ __('dashboard.backGround') }}
                        </span>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-group">
            <input wire:model="name_ar" type="text" placeholder="{{ __('web.name_ar') }}" required
                value="{{ old('name_ar') }}">
        </div>
        <div class="form-group">
            <input wire:model="name_en" type="text" placeholder="{{ __('web.name_en') }}"required
                value="{{ old('name_en') }}">
        </div>
        <div class="form-group">
            <textarea wire:model="desc_ar" class="form-control" id="validationTextarea" cols="30" rows="3" required
                placeholder="{{ __('dashboard.desc_ar') }}"></textarea>
        </div>
        <div class="form-group">
            <textarea wire:model="desc_en" class="form-control" id="validationTextarea" cols="30" rows="3" required
                placeholder="{{ __('dashboard.desc_en') }}"></textarea>
        </div>
        <div class="form-group">
            <input wire:model="resturnPhone" placeholder="{{ __('dashboard.resturnPhone') }}" pattern="[0-9]+"
                title="{{ __('dashboard.resturnPhone') }}" type="tel" required maxlength="10"
                value="{{ old('resturnPhone') }}">
        </div>

        <div class="form-group">
            <input wire:model="address" type="text" placeholder="{{ __('dashboard.address') }}" required
                value="{{ old('address') }}">
        </div>
        <div class="form-group">
            <input wire:model="lat" placeholder="{{ __('dashboard.lat') }}" type="tel" required
                value="{{ old('lat') }}">
        </div>
        <div class="form-group">
            <input wire:model="long" placeholder="{{ __('dashboard.long') }}" type="tel" required
                value="{{ old('long') }}">
        </div>
        <div class="form-group">
            <input wire:model="link" placeholder="{{ __('dashboard.link') }}" type="url" value="{{ old('link') }}">
        </div>
        <div class="form-group">
            <input wire:model="delivaryCost" placeholder="{{ __('dashboard.delivaryCost') }}" type="number" min="0" step="0.1"
                required value="{{ old('delivaryCost') }}">
        </div>
        <div class="form-group">
            <input wire:model="time" placeholder="{{ __('dashboard.time') }}" type="number" min="0" step="0.1" required
                value="{{ old('time') }}">
        </div>
        <div class="form-group">
            <label for="validationTextarea" class="form-label">{{ __('dashboard.category') }}</label>
            <br>
            @foreach ($subCategories as $category)
                <label class="checkbox-inline">
                    <input wire:model="subCategories[]" type="checkbox" class="chk-box" value="{{ $category->id }}">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>
        <div class="form-group">
            <label for="validationTextarea" class="form-label">{{ __('web.account') }}</label>
            <br>
            <select onclick="accountChange(this)">
                <option value=""></option>
                <option value="yes">{{ __('web.yes') }}</option>
                <option value="no">{{ __('web.no') }}</option>
            </select>
        </div>

        <div class="form-group" id="email" style="display:none;">
            <input wire:model="email" type="email" placeholder="{{ __('dashboard.email') }}" id="emailInput"
                value="{{ old('email') }}">
        </div>
        <b><p style="color: red; display:none" id="emailInfo">{{ __('web.emailInfo') }}</p></b>
        <br>
        <div id="dataInfo" style="display:none;">
            <div class="form-group">
                <input wire:model="name" type="text" placeholder="{{ __('dashboard.name') }}" name="name" required
                    id="inputName" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <input wire:model="emailinput" type="email" placeholder="{{ __('dashboard.email') }}" id="emailInput2"
                    value="{{ old('emailinput') }}">
            </div>
            <div class="form-group">
                <input wire:model="phone" placeholder="{{ __('dashboard.phone') }}" pattern="[0-9]+"
                    title="{{ __('dashboard.phone') }}" type="tel" required id="inputPhone" maxlength="10"
                    value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <input wire:model="password" type="password" placeholder="{{ __('dashboard.password') }}"
                    id="inputPassword" value="{{ old('password') }}">
            </div>
        </div>

        <div class="form-group">
            <input type="checkbox" class="d-none" name="" id="agree" required>
            <label for="agree" class="agree">
                <span><i class="fa fa-check"></i></span>
                {{ __('web.accepet') }}
                <a href="#">{{ __('web.terms') }}</a>
            </label>
        </div>

        <div class="form-submit">
            <button class="btn hover" style="background-color:#E54847">{{ __('web.request') }}</button>
        </div>
    </form>
</div>
