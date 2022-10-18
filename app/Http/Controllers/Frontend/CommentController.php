<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComments()
    {
        $comments = Comment::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'comments' => $comments
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required'
        ]);

        $comment = new Comment;
        $comment->post_id = $request->input('post_id');
        $comment->name = $request->input('name');
        $comment->email = $request->input('email');
        $comment->comment = $request->input('comment');
        $comment->save();

        if($comment) {
            return response()->json([
                'status' => true,
                'message' => 'you made comment on this post'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'you did not make comment on this post'
            ]);
        }
    }
}
