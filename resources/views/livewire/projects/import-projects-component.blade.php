
<div>
    <div class="bg-yellow-100 p-2 text-sm">
        <div><strong>hasPreview:</strong> {{ $hasPreview ? 'YES' : 'NO' }}</div>
        <div><strong>Row count:</strong> {{ $previewRows?->count() ?? 0 }}</div>
        <div><strong>File:</strong> {{ $file ? $file->getClientOriginalName() : 'No file selected' }}</div>
    </div>
    <input type="file" wire:model="file">
        @error('file') <span class="text-red-500">{{ $message }}</span> @enderror
    
        @if ($hasPreview)
            <table class="table-auto w-full mt-4 text-sm">
                <thead>
                    <tr>
                        @foreach ($previewRows->first() as $header => $value)
                            <th class="px-2 py-1 border">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($previewRows as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td class="px-2 py-1 border">{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
    
            <form wire:submit.prevent="import" class="mt-4">
                <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded">
                    Confirm Import
                </button>
            </form>
        @endif
    
        @if (session()->has('message'))
            <p class="mt-4 text-green-600">{{ session('message') }}</p>
        @endif
    </div>