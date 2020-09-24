@component('mail::message')
# Перевозчик {{$user->name}} {{$user->surname}} изменил свои данные!
## Проверьте его!
@component('mail::button', ['url' => route('admin.users.edit', $user)])
Проверить
@endcomponent
@endcomponent
