@extends('layouts.admin', ['title' => __('admin.users.title')])
@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush
@section('content')

    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">
                <span>{{ __('admin.users.fields.name') }}</span>
            </label>
            <input
                id="name"
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                autocomplete="name"
                required
                autofocus
            />
        </div>
        <div class="form-group">
            <label for="surname" class="form-label">
                <span>{{ __('auth.surname') }}</span>
            </label>
            <input
                id="surname"
                type="text"
                name="surname"
                class="form-control"
                value="{{ old('surname') }}"
                autocomplete="surname"
            />
        </div>

        <div class="form-group">
            <label for="email" class="form-label">
                <span>E-mail</span>
            </label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            />
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">
                <span>{{ __('admin.users.fields.phone') }}</span>
            </label>
            <input
                id="phone"
                type="tel"
                name="phone"
                class="form-control"
                value="{{ old('phone') ?? ' '}}"
                placeholder="380 00 000-00-00"
                v-mask="'{38\\0} 000 000-00-00'"
                autocomplete="phone"
                required
            />
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                <span>{{ __('auth.password') }}</span>
            </label>
            <input id="password" type="password"
                   class="form-control{{ $errors->has('password') ? ' has-error' : '' }}"
                   name="password" value="{{ old('password') }}" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password-confirm" class="form-label">
                <span>{{ __('auth.password_confirmation') }}</span>
            </label>
            <input id="password-confirm" type="password"
                   class="form-control{{ $errors->has('password') ? ' has-error' : '' }}"
                   name="password_confirmation" required autocomplete="new-password">
        </div>

        <regions-cities-select
            region="{{ old('region_id')  }}"
            city="{{ old('city_id')  }}"
        ></regions-cities-select>

        <div class="form-group">
            <label for="role" class="form-label">
                <span>{{ __('admin.users.fields.role') }}</span>
            </label>

            <select name="role" id="role" class="form-control" onchange="rolesInput()" required>
                @foreach(\App\Models\User::$ROLES as $role)
                    <option
                        value="{{ $role }}"
                        {{ $role === old('role') ? 'selected' : '' }}
                    >
                        {{ __('auth.roles.' . $role) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="hidden" id="for-carrier">
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
                            >{{ old('carrier_description.' . $locale) }}</textarea>
                        </div>
                    </fieldset>
                @endforeach
            </locales>
            <div class="form-group">
                <label for="type_car" class="form-label{{ $errors->has('type_car') ? ' has-error' : '' }}">
                    <span>{{ __('auth.type_car') }}</span>
                </label>
                <input id="type_car" type="text" class="form-control{{ $errors->has('type_car') ? ' has-error' : '' }}"
                       name="type_car" value="{{ old('type_car') }}">
            </div>
            <div class="form-group">
                <label for="brand_car" class="form-label{{ $errors->has('brand_car') ? ' has-error' : '' }}">
                    <span>{{ __('auth.brand_car') }}</span>
                </label>
                <input id="brand_car" type="text"
                       class="form-control{{ $errors->has('brand_car') ? ' has-error' : '' }}"
                       name="brand_car" value="{{ old('brand_car') }}">
            </div>
            <div class="flex flex-wrap -mx-2">
                <div class="form-group w-1/2 px-2">
                    <label for="tonnage" class="form-label"><span>{{ __('auth.tonnage') }}</span></label>
                    <input name="tonnage" id="tonnage" type="number" class="form-control" step="0.001" min="0.001"
                           value="{{ old('tonnage') }}">
                </div>
                <div class="form-group w-1/2 px-2">
                    <label for="price_km" class="form-label"><span>{{ __('auth.price_km') }}</span></label>
                    <input name="price_km" id="price_km" type="number" class="form-control" step="0.01" min="0.01"
                           value="{{ old('price_km') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="car_region" class="form-label">
                    <span>{{ __('auth.car_region') }}</span>
                </label>
                <select name="car_region" id="car_region" class="form-control">
                    <option value="" disabled selected></option>
                    @foreach($regions as $region)
                        <option
                            value="{{ $region->id }}"
                            {{ $region === old('car_region') ? 'selected' : '' }}
                        >
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-checkbox">
                <input type="checkbox" name="all_region" id="all_region" checked onchange="addWorkedRegion()">
                <label for="all_region">{{ __('auth.all_region') }}</label>
            </div>
            <div class="flex flex-wrap mt-4 mb-3 hidden" id="addWorkedRegion">
                <p class="mb-2">{{__('auth.worked_region')}}</p>
                @foreach($regions as $region)
                    <div class="form-checkbox">
                        <input type="checkbox" name="worked_region[]" id="worked_region-{{$region->id}}"
                               value="{{$region->id}}">
                        <label for="worked_region-{{$region->id}}" class="form-label">{{$region->name}}</label>
                    </div>
                @endforeach
            </div>
            <media-upload class="mt-6" label="{{ __('auth.add_photo_carrier') }}"></media-upload>
            <div class="form-checkbox mt-4">
                <input type="checkbox" name="published_carrier" id="published_carrier">
                <label for="published_carrier">{{ __('auth.published_carrier') }}</label>
            </div>
        </div>
        <div class="form-group hidden" id="for-buyer">
            <label for="organization" class="form-label{{ $errors->has('organization') ? ' has-error' : '' }}">
                <span>{{ __('auth.organization') }}</span>
            </label>
            <input id="organization" type="text"
                   class="form-control{{ $errors->has('organization') ? ' has-error' : '' }}"
                   name="organization" value="{{ old('organization') }}">
        </div>

        <div class="mt-10">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
            <a href="{{ route('admin.users.index') }}" class="button">
                {{ __('admin.buttons.cancel') }}
            </a>
        </div>
    </form>

@endsection
@push('scripts')
    <script>
        function rolesInput() {
            const buyer = document.querySelector('#for-buyer');
            const carrier = document.querySelector('#for-carrier');
            if (event.target.value === 'buyer') {
                buyer.classList.remove('hidden')
                if (!carrier.classList.contains('hidden')) {
                    carrier.classList.add('hidden')
                }
            } else if (event.target.value === 'carrier') {
                carrier.classList.remove('hidden')
                if (!buyer.classList.contains('hidden')) {
                    buyer.classList.add('hidden')
                }
            } else {
                if (!buyer.classList.contains('hidden')) {
                    buyer.classList.add('hidden')
                }
                if (!carrier.classList.contains('hidden')) {
                    carrier.classList.add('hidden')
                }
            }
        }
        function addWorkedRegion() {
            const checkbokses = document.querySelector('#addWorkedRegion')
            if(!checkbokses.classList.contains('hidden')){
                checkbokses.classList.add('hidden')
            }else{
                checkbokses.classList.remove('hidden')
            }
        }
    </script>
@endpush
