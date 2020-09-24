<thead>
<tr class="text-xs font-semibold uppercase text-gray-500 text-left">
    @foreach($fields as $field)
        <th class="p-3 whitespace-no-wrap border-b-2{{ $loop->last ? ' text-right' : '' }}">
            @if ($field->sortable)
                <a href="{{ \App\Services\DataTables::sortableColumn($field->key) }}"
                   class="flex items-center{{ $loop->last ? ' justify-end' : '' }}">
                    @if (request('sort', optional($fields->firstWhere('default', true))->key) === $field->key)
                        <svg width="15" height="15" fill="currentColor" class="mr-1">
                            <use xlink:href="{{ asset('images/icons/admin.svg#order-').request('order', 'desc') }}"></use>
                        </svg>
                    @endif

                    {{ $field->name }}
                </a>
            @else
                {{ $field->name }}
            @endif
        </th>
    @endforeach
</tr>
</thead>
