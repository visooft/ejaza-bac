<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderSideBar extends Component
{
    public function render()
    {
        $NewCount = Order::where('status', 0)->count();
        $acceptedCount = Order::where('status', 1)->count();
        $rejectedCount = Order::where('status', 2)->count();
        $cancelOrders = Order::where('status', 3)->count();
        return view('livewire.order-side-bar', [
            'NewCount' => $NewCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
            'cancelOrders' => $cancelOrders
        ]);
    }
}
