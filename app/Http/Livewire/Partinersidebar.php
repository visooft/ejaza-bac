<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Housing;
class Partinersidebar extends Component
{
    
    public function render()
    {
        $NewCount = Housing::where(['status' => 0, 'category_id' => 4])->count();
        $acceptedCount = Housing::where(['status' => 1, 'category_id' => 4])->count();
        $rejectedCount = Housing::where(['status' => 2, 'category_id' => 4])->count();
        return view('livewire.partinersidebar', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
