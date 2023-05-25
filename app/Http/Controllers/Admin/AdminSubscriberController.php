<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('id', 'asc')->get();

        if($subscribers->isEmpty()) {
            return response()->json('Contact are Empty');
        }

        return response()->json([
            'status' => true,
            'subscribers' => $subscribers
        ]);
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);

        if(!$subscriber) {
            return response()->json('subscriber not found');
        }

        $subscriber = $subscriber->delete();

        if($subscriber) {
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
