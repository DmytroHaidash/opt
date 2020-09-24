<div class="form-group">
    <label for="name" class="form-label">
        <span>{{ __('auth.name') }}</span>
    </label>
    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}"
           name="name" value="{{ old('name') }}" required autocomplete="name">
</div>

<div class="form-group">
    <label for="email" class="form-label">
        <span>E-mail</span>
    </label>
    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
           name="email" value="{{ old('email') }}" required autocomplete="email">
</div>

<div class="form-group">
    <label for="phone" class="form-label">
        <span>{{ __('auth.phone') }}</span>
    </label>
    <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' has-error' : '' }}"
           name="phone" value="{{ old('phone') ?? ' ' }}"
           v-mask="'{38\\0} 000 000-00-00'"
           required autocomplete="phone">
</div>
