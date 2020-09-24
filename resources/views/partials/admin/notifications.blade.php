@if ($errors->any())
    <div class="bg-red-600 text-white px-6 py-4 rounded my-6 flex">
        <ul class="flex-1 pr-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button type="button" onclick="this.parentElement.style.display = 'none'">&times;</button>
    </div>
@endif

@if(session()->has('success'))
    <div class="bg-green-600 text-white px-6 py-4 rounded my-6 flex">
        <div class="flex-1 pr-6">
            {{ session('success') }}
        </div>

        <button type="button" onclick="this.parentElement.style.display = 'none'">&times;</button>
    </div>
@endif
