@extends('layouts.app')

@section('content')
    <section class="max-w-sm mx-auto my-6 lg:my-12">
        @if (session('status'))
            <div class="mb-6 bg-green-600 text-white rounded px-4 py-3" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label{{ $errors->has('email') ? ' has-error' : '' }}">
                    <span>E-mail</span>
                </label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <div class="text-red-600 text-sm font-bold mt-1" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="button button--primary">
                    {{ __('auth.send_reset_link') }}
                </button>
            </div>
        </form>
    </section>
@endsection
