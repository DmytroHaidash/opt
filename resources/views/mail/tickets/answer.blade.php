<h4>Ответ администрации сайта</h4>
<p><strong>Тема вашего обращения:</strong> {{__('support.subjects.' . $ticket->subject)}}</p>
<p><strong>Ваше сообщение администрации сайта:</strong> {!! nl2br($ticket->message) !!}</p>
<br>
<p><strong>Ответ:</strong> {!! nl2br($answer) !!}}</p>
