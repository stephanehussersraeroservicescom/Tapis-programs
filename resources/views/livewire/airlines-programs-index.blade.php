<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold">Airlines & Programs</h1>

    @foreach($airlines as $airline)
        <div class="bg-white shadow-md rounded-xl p-4">
            <h2 class="text-xl font-semibold">{{ $airline->name }}</h2>
            @if($airline->programs->count())
                <ul class="mt-2 list-disc list-inside">
                    @foreach($airline->programs as $program)
                        <li class="text-gray-700">{{ $program->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">No programs yet.</p>
            @endif
        </div>
    @endforeach
</div>
