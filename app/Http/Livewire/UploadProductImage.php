<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadProductImage extends Component
{
    use WithFileUploads;

    public $images = [];
    public $slot;
    public function mount($slot = 5)
    {
        $this->slot = $slot;
        $this->images = array_fill(0, $slot, null);
    }

    public function remove($index){
        $this->images[$index] = null;
    }
    public function render()
    {
        return view('livewire.upload-product-image');
    }
}
