<div class="p-6 bg-gray-900 text-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4">Gemini Test</h1>

    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
        <input type="file" wire:model="testFile" accept=".txt" class="text-black" required>

        <button type="submit" class="bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded font-semibold shadow">
            Submit
        </button>
    </form>

    @if($processing)
        <div class="mt-4 flex items-center space-x-2 text-yellow-400">
            <span>Processing...</span>
            <svg class="animate-spin h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    @endif

    @if($result)
        <div class="mt-4 p-4 bg-gray-800 rounded">
            <h2 class="font-semibold mb-2">Result:</h2>
            <pre>{{ is_array($result) ? json_encode($result, JSON_PRETTY_PRINT) : $result }}</pre>
        </div>
    @endif
</div>
