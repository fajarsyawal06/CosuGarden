@if(session('success'))
    <div class="p-3 mb-4 bg-green-100 border border-green-200 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-3 mb-4 bg-red-100 border border-red-200 rounded">
        {{ session('error') }}
    </div>
@endif
