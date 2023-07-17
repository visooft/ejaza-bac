<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Housing;

class Campsidebar extends Component
{
    public function render()
    {
        $NewCount = Housing::where(['status' => 0, 'category_id' => 5])->count();
        $acceptedCount = Housing::where(['status' => 1, 'category_id' => 5])->count();
        $rejectedCount = Housing::where(['status' => 2, 'category_id' => 5])->count();
        return view('livewire.campsidebar', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
