<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Amount extends Component
{
    public int $amount = 300;

    public function render()
    {
        return view('livewire.amount');
    }
}
