<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderSellers extends Component
{
    public function render()
    {
        $NewCount = 0;
        $acceptedCount = 0;
        $rejectedCount = 0;
        $cancelOrders = 0;
        return view('livewire.order-sellers',[
            'acceptedCount' => $acceptedCount,
            'NewCount' => $NewCount,
            'rejectedCount' => $rejectedCount,
            'cancelOrders' => $cancelOrders
        ]);
    }
}
