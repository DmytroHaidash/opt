@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush
@section('content')

    <section class="container max-w-3xl mx-auto my-6 lg:my-12">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label{{ $errors->has('name') ? ' has-error' : '' }}">
                    <span>{{ __('auth.name') }}</span>
                </label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
            <div class="form-group">
                <label for="surname" class="form-label{{ $errors->has('surname') ? ' has-error' : '' }}">
                    <span>{{ __('auth.surname') }}</span>
                </label>
                <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' has-error' : '' }}"
                       name="surname" value="{{ old('surname') }}" required autocomplete="surname">
            </div>

            <div class="form-group">
                <label for="email" class="form-label{{ $errors->has('email') ? ' has-error' : '' }}">
                    <span>E-mail</span>
                </label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="phone" class="form-label{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <span>{{ __('auth.phone') }}</span>
                </label>
                <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' has-error' : '' }}"
                       name="phone" value="{{ old('phone') ?? ' ' }}"
                       v-mask="'{38\\0} 000 000-00-00'"
                       required autocomplete="phone">
            </div>

            <div class="form-group">
                <label for="password" class="form-label{{ $errors->has('password') ? ' has-error' : '' }}">
                    <span>{{ __('auth.password') }}</span>
                </label>
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' has-error' : '' }}"
                       name="password" value="{{ old('password') }}" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label{{ $errors->has('password') ? ' has-error' : '' }}">
                    <span>{{ __('auth.password_confirmation') }}</span>
                </label>
                <input id="password-confirm" type="password"
                       class="form-control{{ $errors->has('password') ? ' has-error' : '' }}"
                       name="password_confirmation" required autocomplete="new-password">
            </div>

            <regions-cities-select
                region="{{ old('region_id') }}"
                city="{{ old('city_id') }}"
            ></regions-cities-select>

            <div class="form-group">
                <div class="variants">
                    @foreach(['buyer', 'seller', 'carrier'] as $role)
                        <div class="w-1/3 text-center">
                            <input type="radio" name="role" id="role-{{ $role }}" class="invisible"
                                   value="{{ $role }}" onclick="rolesInput()">
                            <label for="role-{{ $role }}">
                                {{ __('auth.roles.' . $role) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="hidden" id="for-carrier">
                <div class="form-group">
                    <label for="carrier_description-{{ app()->getLocale() }}" class="form-label">
                                    <span>
                                        {{ __('auth.carrier_description') }}
                                    </span>
                    </label>
                    <textarea
                        id="carrier_description-{{ app()->getLocale() }}"
                        name="carrier_description[{{ app()->getLocale() }}]"
                        rows="4"
                        id="carrier_description-{{ app()->getLocale() }}"
                        class="editor"
                    >{{ old('carrier_description.' . app()->getLocale()) }}</textarea>
                </div>
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
                    <input id="brand_car" type="text" class="form-control{{ $errors->has('brand_car') ? ' has-error' : '' }}"
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
                        @foreach(\App\Models\Region::get() as $region)
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
                    @foreach(\App\Models\Region::get() as $region)
                        <div class="form-checkbox">
                            <input type="checkbox" name="worked_region[]" id="worked_region-{{$region->id}}"
                                   value="{{$region->id}}">
                            <label for="worked_region-{{$region->id}}" class="form-label">{{$region->name}}</label>
                        </div>
                    @endforeach
                </div>
                <media-upload class="mt-6" label="{{ __('auth.add_photo_carrier') }}"></media-upload>
            </div>
            <div class="form-group hidden" id="for-buyer">
                <label for="organization" class="form-label{{ $errors->has('organization') ? ' has-error' : '' }}">
                    <span>{{ __('auth.organization') }}</span>
                </label>
                <input id="organization" type="text" class="form-control{{ $errors->has('organization') ? ' has-error' : '' }}"
                       name="organization" value="{{ old('organization') }}">
            </div>

            <div class="mt-6 text-center">
                <button class="button button--primary" type="submit">
                    {{ __('auth.make_register') }}
                </button>
            </div>

            <hr class="border-0 border-b-2 my-6">

            <div class="text-center text-gray-600">
                <p class="mb-3">{{ __('auth.already_registered') }}</p>
                <p><a href="{{ route('login') }}" class="button button--gray">{{ __('auth.login') }}</a></p>
            </div>
        </form>
    </section>

@endsection

@push('scripts')
    <script>
        function rolesInput() {
            const buyer = document.querySelector('#for-buyer');
            const carrier = document.querySelector('#for-carrier');
            if(event.target.value === 'buyer') {
                buyer.classList.remove('hidden')
                if(!carrier.classList.contains('hidden')){
                    carrier.classList.add('hidden')
                }
            }else if(event.target.value === 'carrier'){
                carrier.classList.remove('hidden')
                if(!buyer.classList.contains('hidden')){
                    buyer.classList.add('hidden')
                }
            }else{
                if(!buyer.classList.contains('hidden')){
                    buyer.classList.add('hidden')
                }
                if(!carrier.classList.contains('hidden')){
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
