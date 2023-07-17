<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StoresSideBar extends Component
{
    public function render()
    {
        $NewCount = 0;
        $acceptedCount = 0;
        $rejectedCount = 0;
        return view('livewire.stores-side-bar', [
            'acceptedCount' => $acceptedCount,
            'NewCount' => $NewCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
