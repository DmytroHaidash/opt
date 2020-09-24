@extends('layouts.app', ['title' => __('nav.profile.index')])
@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush
@section('content')

    <section class="my-6 lg:my-12 container">
        @includeIf('client.profile.partials.nav')

        @includeIf('client.profile.user')
    </section>

@endsection

@push('scripts')
    <script>
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

