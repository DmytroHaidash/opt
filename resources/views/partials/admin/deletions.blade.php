<form hidden id="deletion-form" method="post">
    @csrf
    @method('delete')
</form>

@push('scripts')
    <script>
        function handleItemDeletion(route) {
            event.preventDefault();

            const form = document.getElementById('deletion-form');
            const confirmation = confirm('{{ __('admin.messages.delete_confirmation') }}');

            if (confirmation) {
                form.action = route;
                form.submit();
            }
        }
    </script>
@endpush
