<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;

class Payments extends Component
{
    public $name;
    public $type;
    public $state;
    public $image;

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'type' => 'required',
            'state' => 'required',
            'image' => 'required',
        ]);
        //upload multiple images
        $images = array();
        if ($files = $this->image) {
            foreach ($files as $file) {
                $image_name = md5(rand(100, 200));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'images/payments/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                $images[] = $image_url;
            }
        }
        Payment::create([
            'name' => $this->name,
            'type' => $this->type,
            'state' => $this->state,
            'image' => $images,
        ]);

        $this->reset();
        $this->emit('paymentAdded');
    }


    public function render()
    {
        return view('livewire.payments');
    }
}
