@component('mail::message')
# Детали заказа.
# Покупатель: {{ $user->name }}, +{{ $user->phone }}

<div style="margin: 20px 0; border: 2px solid #e2e8f0; border-radius: 4px; overflow: hidden;">
<table style="width: 100%;">
@foreach($products as $product)
<tr style="{{ !$loop->last ? 'border-bottom: 2px solid #e2e8f0' : '' }}">
<td style="padding: 6px; width: 66%;">{{ $product->product->title }}</td>
<td style="padding: 6px; width: 33%;">{{ $product->quantity . ' ' . $product->value->unit->name . ' * ' . $product->value->price }} грн</td>
<td style="padding: 6px;">
<b>{{ $product->quantity * $product->value->price }} грн</b>
</td>
</tr>
@endforeach
</table>
</div>
@endcomponent
