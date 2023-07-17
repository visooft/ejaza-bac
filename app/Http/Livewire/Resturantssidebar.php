<?php

namespace App\Http\Livewire;

use App\Models\Housing;
use Livewire\Component;

class Resturantssidebar extends Component
{
    public function render()
    {
        $NewCount = Housing::where(['status' => 0, 'category_id' => 3])->count();
        $acceptedCount = Housing::where(['status' => 1, 'category_id' => 3])->count();
        $rejectedCount = Housing::where(['status' => 2, 'category_id' => 3])->count();
        return view('livewire.resturantssidebar', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
