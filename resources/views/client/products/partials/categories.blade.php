<div class="form-group">
    <label class="form-label">
        <span>{{ __('admin.products.fields.categories') }}</span>
    </label>

    <div class="max-h-sm overflow-y-auto">
        <nested-checker :active="{{ json_encode(old('categories') ?? (isset($product) ? $product->categories->pluck('id') : [])) }}" inline-template>
            <ul class="px-3 pt-3 pb-1 border-2 rounded">
                @foreach($categories as $category)
                    <li class="{{ !$loop->last ? 'mb-4' : '' }}">
                        <div class="form-checkbox form-checkbox--sm mb-2">
                            <input
                                type="checkbox"
                                name="categories[]"
                                id="category-{{ $category->id }}"
                                value="{{ $category->id }}"
                                @change="handleParent($event, {{ $category->id }},{{ json_encode($category->children->pluck('id')) }})"
                                :checked="checked.includes({{ $category->id }})"
                            >
                            <label for="category-{{ $category->id }}" class="w-full">
                                {{ $category->title }}
                            </label>
                        </div>

                        @if ($category->children->count())
                            <ul class="ml-6">
                                @foreach($category->children as $child)
                                    <li>
                                        <div class="form-checkbox form-checkbox--sm mb-1">
                                            <input
                                                type="checkbox"
                                                name="categories[]"
                                                id="category-{{ $child->id }}"
                                                value="{{ $child->id }}"
                                                @change="handleChild($event, {{ $child->id }}, {{ $child->parent_id }})"
                                                :checked="checked.includes({{ $child->id }})"
                                            >
                                            <label for="category-{{ $child->id }}" class="w-full">
                                                {{ $child->title }}
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nested-checker>
    </div>
</div>
