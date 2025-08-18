<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class TestUpload extends Component
{
    use WithFileUploads;

    public $testFile;

    public function save()
    {
        $this->validate([
            'testFile' => 'required|file|max:10240', // 10MB Max
        ]);

        $this->testFile->store('public');

        session()->flash('success', 'File uploaded successfully!');
    }

    public function render()
    {
        return view('livewire.test-upload');
    }
}