<conditional :approved="{{ old('change_slug') ? 1 : 0 }}" inline-template>
    <div class="flex -mx-6 items-center">
        <div class="px-6 flex-1">
            <div class="form-group">
                <label for="slug" class="form-label">
                    <span>{{ __('admin.pages.fields.slug') }}</span>
                </label>
                <input
                    id="slug"
                    type="text"
                    name="slug"
                    class="form-control"
                    value="{{ old('slug') ?? $page->slug }}"
                    :readonly="!isApproved"
                />
            </div>
        </div>

        <div class="px-6 pt-3">
            <div class="form-checkbox">
                <input
                    type="checkbox" name="change_slug"
                    id="published"
                    {{ old('change_slug') ? 'checked' : '' }}
                    @change="toggle"
                >
                <label for="published">{{ __('admin.pages.fields.change_slug') }}</label>
            </div>
        </div>
    </div>
</conditional>
