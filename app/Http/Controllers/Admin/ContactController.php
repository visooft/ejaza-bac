<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactModel, $userModel;
    public function __construct(Contact $contact, User $user)
    {
        $this->contactModel = $contact;
        $this->userModel = $user;
    }
    public function user()
    {
        $messages = $this->contactModel::orderBy('id', 'DESC')->get();
        foreach ($messages as $message) {
            $message->update([
                'status' => 1
            ]);
        }
        return view('Admin.contact', compact('messages'));
    }
    public function cacher ()
    {
        $messages = $this->contactModel::where('type', 'Cacher')->orderBy('id', 'DESC')->get();
        foreach ($messages as $message) {
            $message->update([
                'status' => 1
            ]);
            if($message->user_id)
            {
                $message->user = $this->userModel::where('id', $message->user_id)->first()->name;
            }
        }
        $type = "Cacher";
        return view('Admin.contact', compact('messages', 'type'));
    }
    public function delivery ()
    {
        $messages = $this->contactModel::where('type', 'Delivary')->orderBy('id', 'DESC')->get();
        foreach ($messages as $message) {
            $message->update([
                'status' => 1
            ]);
            if($message->user_id)
            {
                $message->user = $this->userModel::where('id', $message->user_id)->first()->name;
            }
        }
        $type = "Delivary";
        return view('Admin.contact', compact('messages', 'type'));
    }

    public function showmessage($id)
    {
        $this->contactModel::where('id', $id)->update(['user_id' => auth()->user()->id]);
        return back();
    }
    public function delete(Request $request)
    {
        $request->validate([
            'messageId' => 'required|exists:contacts,id'
        ]);

        $message = $this->contactModel::find($request->messageId);
        $message->delete();
        return back()->with('done', __('dashboard.deleteMessageReturn'));
    }
}
