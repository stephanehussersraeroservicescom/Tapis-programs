<!-- filepath: /home/stephane/Laravel/Tapis-programs/resources/views/livewire/project-dashboard.blade.php -->
<div class="p-4">
    <h1 class="text-2xl font-semibold mb-4">Project Dashboard</h1>

    <div class="p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <select wire:model.live="rep" class="border p-2 rounded">
                <option value="">All Reps</option>
                @foreach ($reps as $r)
                    <option value="{{ $r }}">{{ $r }}</option>
                @endforeach
            </select>
        </div>

        <table class="w-full table-auto text-sm border mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Date</th>
                    <th class="border px-2 py-1">Tapis Ref</th>
                    <th class="border px-2 py-1">Rep</th>
                    <th class="border px-2 py-1">Style</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td class="border px-2 py-1">{{ $project->date }}</td>
                        <td class="border px-2 py-1">{{ $project->tapis_ref }}</td>
                        <td class="border px-2 py-1">{{ $project->rep->name ?? '' }}</td>
                        <td class="border px-2 py-1">{{ $project->style }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No projects found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $projects->links() }}
        </div>
    </div>
</div>