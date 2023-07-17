<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BalanaceRequest extends Component
{
    public function render()
    {
        $balanceCount = 0;
        return view('livewire.balanace-request', [
            'balanceCount' => $balanceCount
        ]);
    }
}
