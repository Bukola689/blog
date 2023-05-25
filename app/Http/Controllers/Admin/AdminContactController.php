<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->get();

        if($contacts->isEmpty()) {
            return response()->json('Contact are Empty');
        }

        return response()->json([
            'status' => true,
            'contacts' => $contacts
        ]);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if(!$contact) {
            return response()->json('contact not found');
        }

        $contact = $contact->delete();

        if($contact) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted Successfully' 
            ]);
        }

        else {
            return response()->json([
                'status' => false,
                'message' => 'not found'
            ]);
        }
    }
}
