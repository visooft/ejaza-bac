<?php

namespace App\Http\Livewire;

use App\Models\Housing;
use Livewire\Component;

class Guide extends Component
{
    public function render()
    {
        $NewCount = Housing::where(['category_id' => 7, 'status' => 0])->count();
        $acceptedCount = Housing::where(['category_id' => 7, 'status' => 1])->count();
        $rejectedCount = Housing::where(['category_id' => 7, 'status' => 2])->count();
        return view('livewire.guide', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
