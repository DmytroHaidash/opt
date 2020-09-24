@extends('layouts.admin', ['title' => __('admin.tickets.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.tickets.title') }}</h1>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($tickets as $ticket)
            <tr>
                <td class="p-3">{{ $ticket->id }}</td>
                <td class="p-3">
                    <div class="w-2 h-2 mx-auto rounded-full bg-{{ $ticket->is_resolved ? 'green' : 'red' }}-600"></div>
                </td>
                <td class="p-3 w-4/5">{{ $ticket->user->name }}</td>
                <td class="p-3 whitespace-no-wrap">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :show="route('admin.tickets.show', $ticket)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $tickets->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
