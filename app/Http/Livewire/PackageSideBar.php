<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PackageSideBar extends Component
{
    public function render()
    {
        $NewCount = 0;
        $acceptedCount = 0;
        $rejectedCount = 0;
        $cancelPackages = 0;
        return view('livewire.package-side-bar', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
            'cancelPackages' => $cancelPackages
        ]);
    }
}
