<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $subscriber = new Subscriber;
        $subscriber->email = $request->input('email');
        $subscriber->save();

        if($subscriber) {
            return response()->json([
                'status' => true,
                'message' => 'Subscriber Successfully !'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Somethin Went Wrong !'
            ]);
        }
    }
}
