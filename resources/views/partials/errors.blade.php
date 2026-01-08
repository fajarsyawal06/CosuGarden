@if($errors->any())
    <div class="p-3 mb-4 bg-red-50 border border-red-200 rounded">
        <div class="font-semibold mb-2">Terjadi kesalahan:</div>
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
