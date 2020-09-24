<div class="flex -mx-1">
    @if ($show)
        <a href="{{ $show }}"
           class="text-gray-500 hover:text-blue-600 px-1"
           title="{{ __('admin.buttons.show') }}">
            <svg class="w-6 h-5 fill-current">
                <use xlink:href="{{ asset('images/icons/admin.svg#eye') }}"></use>
            </svg>
        </a>
    @endif

    @if ($edit)
        <a href="{{ $edit }}"
           class="text-gray-500 hover:text-yellow-600 px-1"
           title="{{ __('admin.buttons.edit') }}">
            <svg class="w-5 h-5 fill-current">
                <use xlink:href="{{ asset('images/icons/admin.svg#edit') }}"></use>
            </svg>
        </a>
    @endif

    @if ($delete)
        <a href="{{ $delete }}"
           class="text-gray-500 hover:text-red-600 px-1"
           title="{{ __('admin.buttons.delete') }}"
           onclick="handleItemDeletion('{{ $delete }}')">
            <svg class="w-5 h-5 fill-current">
                <use xlink:href="{{ asset('images/icons/admin.svg#trash') }}"></use>
            </svg>
        </a>
    @endif
</div>
