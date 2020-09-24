@extends('layouts.app')

@section('content')

    <section class="container max-w-sm mx-auto my-6 lg:my-12">
        <h3 class="font-bold font-slab mb-3">{{ __('auth.verify.title') }}</h3>

        @if (session('resent'))
            {{ __('auth.verify.resent') }}
        @endif

        {{ __('auth.verify.text') }}

        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <button class="border-b border-gray-700 hover:border-gray-600 transition duration-300">
                {{ __('auth.verify.btn') }}
            </button>
        </form>
    </section>

@endsection
