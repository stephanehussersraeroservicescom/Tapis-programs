<div>
    <label for="program">Select Program</label>
    <select wire:model="programId">
        <option value="">-- Choose Program --</option>
        @foreach($programs as $program)
            <option value="{{ $program->id }}">{{ $program->name }} ({{ $program->airline->name }})</option>
        @endforeach
    </select>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Tapis Part #</th>
                <th>Airline</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partNumbers as $pn)
                <tr>
                    <td><input type="checkbox" wire:model="selected" value="{{ $pn->id }}"></td>
                    <td>{{ $pn->tapis_part_number }}</td>
                    <td>{{ $pn->airline?->name }}</td>
                    <td>{{ $pn->color_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button wire:click="assign">Assign Selected</button>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
