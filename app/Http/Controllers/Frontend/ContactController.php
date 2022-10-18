<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:15',
            'email' => 'required|unique:contacts',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $contact = new Contact;
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');
        $contact->save();

       if($contact) {
        return response()->json([
            'status' => true,
            'message' => 'Contact Successsfully, Admin will send you an email shortly !'
        ]);
       } else {
          return response()->json([
            'status' => false,
            'message' => 'Check Your Data And Try Again Later !'
          ]);
       }

    }  
}
