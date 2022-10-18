<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'comments' => $comments
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment = $comment->delete();

        if($comment) {
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
