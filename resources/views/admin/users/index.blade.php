@extends('layouts.admin', ['title' => __('admin.users.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.users.title') }}</h1>
        </div>

        <div class="px-6">
            <a href="{{ route('admin.users.export') }}" class="button button--primary-outline button--sm">
                {{ __('admin.users.export') }}
            </a>
            <a href="{{ route('admin.users.create') }}" class="button button--primary button--sm">
                {{ __('admin.users.create') }}
            </a>
        </div>
    </div>
    <div class="px-6 mb-2">
        @foreach(\App\Models\User::$ROLES as $role)
            <a href="{{request()->filled('q')?'?q='.request('q').'&': ''}}?role={{ $role }}"
               class="button {{request('role') == $role ? 'button--primary': 'button--primary-outline'}} mt-2 mr-2">
                {{ __('auth.roles.' . $role) }}
            </a>
        @endforeach
        @if (request()->has('role'))
                <a href="{{ route('admin.users.index') }}" class="button button--primary-outline mr-2 mt-2">
                    Очистить все фильтры
                </a>
        @endif
    </div>
    <table class="w-full">
        <x-table-header/>

        @forelse($users as $user)
            <tr class="{{ !$user->active ? 'text-gray-500' : '' }}">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3 w-1/3">{{ $user->name }} {{$user->surname}}</td>
                <td class="p-3 w-1/3">{{ $user->phone }}</td>
                <td class="p-3 w-1/3">{{ __('auth.roles.' . $user->role) }}</td>
                <td class="p-3 text-center">
                    <form action="{{ route('admin.users.access', $user) }}" method="post">
                        @csrf
                        <button
                            class="text-{{ $user->active ? 'gray-500' : 'red-600' }} hover:text-gray-800 block mx-auto"
                            {{ $user->id === Auth::user()->id ? 'disabled' : '' }}
                        >
                            <svg class="w-5 h-5 fill-current">
                                <use
                                    xlink:href="{{ asset('images/icons/admin.svg#lock-') . ($user->active ? 'open' : 'close') }}"></use>
                            </svg>
                        </button>
                    </form>
                </td>

                <td class="p-3 whitespace-no-wrap">
                    @if($user->hasRole('carrier'))
                        @if($user->published_carrier)
                            {{ __('admin.products.statuses.published') }}
                        @else
                            {{ __('admin.products.statuses.not_published') }}
                        @endif
                    @endif
                </td>

                <td class="p-3 w-8">
                    @if ($user->id === Auth::user()->id)
                        <x-table-actions
                            :show="route('admin.users.show', $user)"
                            :edit="route('admin.users.edit', $user)"
                        />
                    @else
                        <x-table-actions
                            :show="route('admin.users.show', $user)"
                            :edit="route('admin.users.edit', $user)"
                            :delete="route('admin.users.destroy', $user)"
                        />
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $users->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
