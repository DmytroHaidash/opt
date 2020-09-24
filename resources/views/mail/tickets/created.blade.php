@component('mail::message')
# Зарегистрировано новое обращение.

#### Сообщение:
{!! nl2br($ticket->message) !!}

@component('mail::button', ['url' => route('admin.tickets.show', $ticket)])
Просмотреть обращение
@endcomponent
@endcomponent
