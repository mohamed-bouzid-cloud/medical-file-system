<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <input type="file" wire:model="testFile">
        <button type="submit">Upload File</button>
    </form>

    @if (session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    @error('testFile')
        <p style="color: red;">{{ $message }}</p>
    @enderror
</div>