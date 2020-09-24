<form action="{{ route('client.profile.update') }}" method="post" class="max-w-3xl mx-auto"
      enctype="multipart/form-data">
    @csrf
    @method('patch')
    <image-upload
        image="{{ $avatar }}"
        name="avatar"
        class="max-w-sm mb-6 mx-auto"
    ></image-upload>

    <div class="form-group">
        <label for="name" class="form-label">
            <span>{{ __('auth.name') }}</span>
        </label>
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}"
               name="name" value="{{ old('name') ?? Auth::user()->name }}" required autocomplete="name"
               autofocus>
    </div>
    <div class="form-group">
        <label for="surname" class="form-label">
            <span>{{ __('auth.surname') }}</span>
        </label>
        <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' has-error' : '' }}"
               name="surname" value="{{ old('surname') ?? Auth::user()->surname }}" required autocomplete="surname"
        >
    </div>
    <div class="form-group">
        <label for="email" class="form-label">
            <span>E-mail</span>
        </label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
               name="email" value="{{ old('email') ?? Auth::user()->email }}" readonly required
               autocomplete="email">
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">
            <span>{{ __('auth.phone') }}</span>
        </label>
        <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' has-error' : '' }}"
               name="phone" value="{{ old('phone') ?? Auth::user()->phone }}"
               placeholder="380 00 000-00-00"
               v-mask="'{38\\0} 000 000-00-00'"
               required autocomplete="email"
        >
    </div>

    @if(Auth::user()->hasRole('carrier'))
        <locales v-slot="{current}">
            @foreach(config('translatable.locales') as $locale)
                <fieldset v-show="current === '{{ $locale }}'">
                    <div class="form-group">
                        <label for="carrier_description-{{ $locale }}" class="form-label">
                                    <span>
                                        {{ __('auth.carrier_description') }}
                                        <span class="uppercase text-gray-400">({{ $locale }})</span>
                                    </span>
                        </label>
                        <textarea
                            id="carrier_description-{{ $locale }}"
                            name="carrier_description[{{ $locale }}]"
                            rows="4"
                            id="carrier_description-{{ $locale }}"
                            class="editor"
                        >{{ old('carrier_description.' . $locale) ?? Auth::user()->getTranslation('carrier_description', $locale) }}</textarea>
                    </div>
                </fieldset>
            @endforeach
        </locales>
        <div class="form-group">
            <label for="type_car" class="form-label{{ $errors->has('type_car') ? ' has-error' : '' }}">
                <span>{{ __('auth.type_car') }}</span>
            </label>
            <input id="type_car" type="text" class="form-control{{ $errors->has('type_car') ? ' has-error' : '' }}"
                   name="type_car" value="{{ old('type_car') ?? Auth::user()->type_car }}">
        </div>
        <div class="form-group">
            <label for="brand_car" class="form-label{{ $errors->has('brand_car') ? ' has-error' : '' }}">
                <span>{{ __('auth.brand_car') }}</span>
            </label>
            <input id="brand_car" type="text" class="form-control{{ $errors->has('brand_car') ? ' has-error' : '' }}"
                   name="brand_car" value="{{ old('brand_car') ?? Auth::user()->brand_car }}">
        </div>
        <div class="flex flex-wrap -mx-2">
            <div class="form-group w-1/2 px-2">
                <label for="tonnage" class="form-label"><span>{{ __('auth.tonnage') }}</span></label>
                <input name="tonnage" id="tonnage" type="number" class="form-control" step="0.001" min="0.001"
                       value="{{ old('tonnage') ?? Auth::user()->tonnage}}">
            </div>
            <div class="form-group w-1/2 px-2">
                <label for="price_km" class="form-label"><span>{{ __('auth.price_km') }}</span></label>
                <input name="price_km" id="price_km" type="number" class="form-control" step="0.01" min="0.01"
                       value="{{ old('price_km')?? Auth::user()->price_km }}">
            </div>
        </div>
        <div class="form-group">
            <label for="car_region" class="form-label">
                <span>{{ __('auth.car_region') }}</span>
            </label>
            <select name="car_region" id="car_region" class="form-control">
                <option value="" disabled></option>
                @foreach($regions as $region)
                    <option
                        value="{{ $region->id }}"
                        {{ $region === Auth::user()->car_region ? 'selected' : '' }}
                    >
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-checkbox">
            <input type="checkbox" name="all_region" id="all_region" {{Auth::user()->all_region ? 'checked' : ''}}
            onchange="addWorkedRegion()">
            <label for="all_region">{{ __('auth.all_region') }}</label>
        </div>
        <div class="flex flex-wrap mt-4 mb-3 {{Auth::user()->all_region ? 'hidden' : ''}}" id="addWorkedRegion">
            <p class="mb-2">{{__('auth.worked_region')}}</p>

            @foreach($regions as $region)
                <div class="form-checkbox">
                    <input type="checkbox" name="worked_region[]" id="worked_region-{{$region->id}}"
                           value="{{$region->id}}" {{in_array($region->id, Auth::user()->carrier_regions->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label for="worked_region-{{$region->id}}" class="form-label">{{$region->name}}</label>
                </div>
            @endforeach
        </div>
        <media-upload
            class="mt-6"
            label="{{ __('admin.buttons.upload') }}"
            :items="{{ json_encode(Auth::user()->truck) }}"
        ></media-upload>
    @endif
    @if(Auth::user()->hasRole('buyer'))
        <div class="form-group hidden">
            <label for="organization" class="form-label{{ $errors->has('organization') ? ' has-error' : '' }}">
                <span>{{ __('auth.organization') }}</span>
            </label>
            <input id="organization" type="text"
                   class="form-control{{ $errors->has('organization') ? ' has-error' : '' }}"
                   name="organization" value="{{ old('organization')?? Auth::user()->organization }}">
        </div>
    @endif
    <div class="mt-6 text-center">
        <button class="button button--primary">{{ __('Обновить') }}</button>
    </div>

    <hr class="border-0 border-b-2 my-6">

    <div class="text-center">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-orange-600">
                {{ __('auth.reset_password') }}
            </a>
        @endif
    </div>
</form>
