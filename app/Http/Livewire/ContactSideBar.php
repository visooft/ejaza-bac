<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactSideBar extends Component
{
    public function render()
    {
        $userMessages = Contact::where('status', 0)->count();
        return view('livewire.contact-side-bar', [
            'userMessages' => $userMessages,
        ]);
    }
}
