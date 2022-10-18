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

        return response()->json([
            'status' => true,
            'contacts' => $contacts
        ]);
    }

    public function destroy(Contact $contact)
    {
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
