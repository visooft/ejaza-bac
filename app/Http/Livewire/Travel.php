<?php

namespace App\Http\Livewire;

use App\Models\Housing;
use Livewire\Component;

class Travel extends Component
{
    public function render()
    {
        $NewCount = Housing::where(['category_id' => 8, 'status' => 0])->count();
        $acceptedCount = Housing::where(['category_id' => 8, 'status' => 1])->count();
        $rejectedCount = Housing::where(['category_id' => 8, 'status' => 2])->count();
        return view('livewire.travel', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
