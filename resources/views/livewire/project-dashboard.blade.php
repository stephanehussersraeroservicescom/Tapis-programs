<div class="p-4">
    <h1 class="text-2xl font-semibold mb-4">Project Dashboard</h1>

    <div class="p-4 space-y-4">
        <p class="text-red-500 mt-4">Search: {{ $search }}</p>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text" wire:model.live="search" placeholder="Search..." class="border p-2 rounded">
    
            <select wire:model.live="status" class="border p-2 rounded">
                <option value="">All Statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
    
            <select wire:model.live="rep" class="border p-2 rounded">
                <option value="">All Reps</option>
                @foreach ($reps as $r)
                    <option value="{{ $r }}">{{ $r }}</option>
                @endforeach
            </select>
    
            <select wire:model.live="airline" class="border p-2 rounded">
                <option value="">All Airlines</option>
                @foreach ($airlines as $a)
                    <option value="{{ $a }}">{{ $a }}</option>
                @endforeach
            </select>
    
            <select wire:model.live="mill" class="border p-2 rounded">
                <option value="">All Mills</option>
                @foreach ($mills as $m)
                    <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
            </select>
        </div>

    <table class="w-full table-auto text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Tapis Ref</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Rep</th>
                <th class="border px-2 py-1">Mill</th>
                <th class="border px-2 py-1">Style</th>
                <th class="border px-2 py-1">Airline</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td class="border px-2 py-1">{{ $project->date }}</td>
                    <td class="border px-2 py-1">{{ $project->tapis_ref }}</td>
                    <td class="border px-2 py-1">{{ $project->status }}</td>
                    <td class="border px-2 py-1">{{ $project->rep->name ?? '' }}</td>
                    <td class="border px-2 py-1">{{ $project->mill->name ?? '' }}</td>
                    <td class="border px-2 py-1">{{ $project->style }}</td>
                    <td class="border px-2 py-1">{{ $project->airline->name ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No projects found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>