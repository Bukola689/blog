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

        if($comments->isEmpty()) {
            return response()->json('Comment are Empty');
        }

        return response()->json([
            'status' => true,
            'comments' => $comments
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json('comment not found');
        }

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
