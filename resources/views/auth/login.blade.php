@extends('layouts.app')

@section('content')

    <section class="container max-w-sm mx-auto my-6 lg:my-12">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label{{ $errors->has('email') ? ' has-error' : '' }}">
                    <span>E-mail</span>
                </label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label{{ $errors->has('password') ? ' has-error' : '' }}">
                    <span>{{ __('auth.password') }}</span>
                </label>
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' has-error' : '' }}"
                       name="password" value="{{ old('password') }}" required autocomplete="current-password">
            </div>

            <div class="flex justify-between items-center -mx-4">
                <div class="px-4">
                    <div class="form-checkbox mb-0">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">{{ __('auth.remember_me') }}</label>
                    </div>
                </div>

                <div class="px-4">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-orange-600">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="mt-6 text-center">
                <button class="button button--primary" type="submit">
                    {{ __('auth.login') }}
                </button>
            </div>

            <hr class="border-0 border-b-2 my-6">

            <div class="text-center text-gray-600">
                <p class="mb-3">{{ __('auth.not_registered') }}</p>
                <p><a href="{{ route('register') }}" class="button button--gray">{{ __('auth.make_register') }}</a></p>
            </div>
        </form>
    </section>

@endsection
