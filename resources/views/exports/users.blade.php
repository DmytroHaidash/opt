<table>
    <thead>
    <tr>
        <th>{{__('admin.users.fields.name')}}</th>
        <th>{{ __('auth.surname') }}</th>
        <th>Email</th>
        <th>{{__('admin.users.fields.phone')}}</th>
        <th>{{__('admin.users.fields.role')}}</th>
        <th>{{ __('auth.organization') }}</th>
        <th>{{ __('shop.region') }}</th>
        <th>{{ __('auth.city') }}</th>
        <th>{{ __('admin.users.fields.registered_at') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname}}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ __('auth.roles.' .$user->role) }}</td>
            <td>{{ $user->organization }}</td>
            <td>{{ $user->city->region->name }}</td>
            <td>{{ $user->city->name }}</td>
            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
