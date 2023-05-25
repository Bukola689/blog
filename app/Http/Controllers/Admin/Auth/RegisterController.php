<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        cache()->forget('users:all');

        return response($response, 201);
    }
}
