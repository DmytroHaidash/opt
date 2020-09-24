@component('mail::message')
#Зарегистрировался новый перевозчик!
## Проверьте его и опубликуйте!
@component('mail::button', ['url' => route('admin.users.edit', $user)])
Проверить
@endcomponent
@endcomponent
