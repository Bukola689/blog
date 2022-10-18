<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function admin(Request $request, User $users)
    {
        $users = $request->user();

        return response()->json([$users]);
    }
}
