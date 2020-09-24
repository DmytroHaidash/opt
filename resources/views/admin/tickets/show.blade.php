@extends('layouts.admin', ['title' => $ticket->user->name])

@section('content')

    <section>
        <h1>
            <span class="text-3xl font-bold font-slab">
                {{ $ticket->user->name }}
            </span>
            @empty($ticket->user_id)
                <sup class="ml-2 -mt-4 rounded px-3 py-1 border-2 text-gray-500">{{ __('auth.anonymous') }}</sup>
            @endempty
        </h1>

        <h2 class="text-xl font-bold">
            <a href="tel:{{ $ticket->user->phone }}">+{{ $ticket->user->phone }}</a>
        </h2>

        <p class="my-4">
            {!! nl2br($ticket->message) !!}
        </p>

        <p>
            {{ __('admin.fields.created_at') }} &bull;
            <span class="font-semibold">{{ $ticket->created_at->format('d.m.Y H:i') }}</span>
        </p>

        <form action="{{ route('admin.tickets.handle', $ticket) }}" class="mt-6" method="post">
            @csrf
            @method('patch')

            <button class="button button--{{ $ticket->is_resolved ? 'danger' : 'primary' }}">
                {{ __('admin.tickets.buttons.' . ($ticket->is_resolved ? 'reject' : 'resolve')) }}
            </button>
        </form>

        @if(!$ticket->is_resolved && $ticket->user_id)
        <form action="{{ route('admin.tickets.answer', $ticket) }}" class="mt-6" method="post">
            @csrf

            <div class="form-group">
                <label for="answer" class="form-label"><span>{{ __('admin.tickets.fields.answer_email') }}</span></label>
                <textarea
                    id="answer"
                    name="answer"
                    rows="4"
                    class="form-control"
                    required
                >{{ old('answer') }}</textarea>
            </div>

            <button class="button button--primary-outline">
                {{ __('admin.tickets.buttons.answer') }}
            </button>
        </form>
            @endif
    </section>

@endsection
