<hr class="border-0 border-b-2 my-6">

<form action="{{ route('client.tickets.create') }}" method="post">
    @csrf

    @guest
        <div class="form-group">
            <label for="name" class="form-label">
                <span>{{ __('auth.name') }}</span>
            </label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}"
                   name="name" value="{{ old('name') }}" required autocomplete="name">
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">
                <span>{{ __('auth.phone') }}</span>
            </label>
            <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' has-error' : '' }}"
                   name="phone" value="{{ old('phone') ?? ' '}}"
                   placeholder="380 00 000-00-00"
                   v-mask="'{38\\0} 000 000-00-00'"
                   required autocomplete="phone">
        </div>
    @endguest

    <div class="form-group">
        <label for="subject" class="form-label">
            <span>{{ __('support.reason') }}</span>
        </label>
        <select name="subject" id="subject" class="form-control" required>
            @foreach(\App\Models\Ticket::$SUBJECTS as $subject)
                <option value="{{ $subject }}"
                    {{ old('subject') === $subject ? 'selected' : '' }}
                >
                    {{ __('support.subjects.' . $subject) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="message" class="form-label">
            <span>{{ __('support.message') }}</span>
        </label>
        <textarea name="message" id="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
    </div>

    <div class="mt-6">
        <button class="button button--primary">{{ __('Отправить') }}</button>
    </div>
</form>
