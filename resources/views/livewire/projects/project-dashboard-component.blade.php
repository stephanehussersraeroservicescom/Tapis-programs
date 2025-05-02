<div class="p-4">
    <h1 class="text-2xl font-semibold mb-4">Project Dashboard</h1>

    <div class="flex flex-wrap gap-2 mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Search projects..." class="border px-2 py-1 rounded" />
        <input type="text" wire:model.debounce.500ms="status" placeholder="Status" class="border px-2 py-1 rounded" />
        <input type="text" wire:model.debounce.500ms="rep" placeholder="Rep" class="border px-2 py-1 rounded" />
        <input type="text" wire:model.debounce.500ms="airline" placeholder="Airline" class="border px-2 py-1 rounded" />
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
