<div class="fixed top-0 right-0 m-6 max-w-xs z-100 notifications">
    @if ($errors->any())
        <div class="bg-red-600 text-white px-3 py-2 lg:px-6 lg:py-4 rounded my-2 flex">
            <ul class="flex-1 pr-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" onclick="this.parentElement.style.display = 'none'">&times;</button>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="bg-green-600 text-white px-3 py-2 lg:px-6 lg:py-4 rounded my-2 flex">
            <div class="flex-1 pr-6">
                {{ session('success') }}
            </div>

            <button type="button" onclick="this.parentElement.style.display = 'none'">&times;</button>
        </div>
    @endif
</div>
