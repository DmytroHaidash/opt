@component('mail::message')
# Детали заказа № {{ $order->id }}

@foreach($order->carts as $item)
## {{ $item->product->title }}
### {{ $item->product->user->name }}, {{ __('shop.city', ['city' => $item->product->city->name]) }}
@endforeach
@endcomponent
