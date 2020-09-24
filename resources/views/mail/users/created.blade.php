@component('mail::message')
    # {{ $user->name }}, добро пожаловать!

    ### Регистрационные данные
    Email: {{ $user->email }}
    Пароль: {{ $password }}
@endcomponent
