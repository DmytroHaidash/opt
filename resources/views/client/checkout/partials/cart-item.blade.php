<tr class="{{ !$loop->first ? ' border-t-2' : '' }}">
    <td class="p-3 text-gray-500 font-bold">{{ $loop->iteration }}</td>
    <td class="p-3 w-20">
        <img src="{{ $item->product->thumb }}" class="rounded block w-12 h-12" alt="">
    </td>
    <td class="p-3">
        <h3 class="font-bold font-slab text-lg leading-none">{{ $item->product->title }}</h3>

        <p class="text-sm font-bold font-slab mt-2">
            {{ $item->product->user->name }}
        </p>

        @if ($item->product->has_delivery)
            <p class="text-sm">
                {!! __('shop.delivery_from', ['city' => $item->product->user->city->name]) !!}
            </p>
        @endif
    </td>
    <td class="p-3 font-bold">
        {{ $item->quantity }}
        {{ $item->value->unit->name }} *
        {{ $item->value->price }} грн
    </td>
    <td class="p-3 font-bold font-slab text-xl">
        {{ $item->value->price * $item->quantity }} грн
    </td>
</tr>
