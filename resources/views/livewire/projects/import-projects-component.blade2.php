<div>
    <form wire:submit.prevent="import" enctype="multipart/form-data">
        <input type="file" wire:model="file">
        @error('file') <p class="text-red-500">{{ $message }}</p> @enderror

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2">Upload</button>
    </form>
</div>