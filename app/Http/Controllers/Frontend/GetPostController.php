<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class GetPostController extends Controller
{
    public function index(Request $request)
    {
        $allPosts = Post::with('category')->orderBy('id', 'desc')->paginate(5);

        return response()->json([
            'success' => true,
            'allPosts' => $allPosts
        ]);
    }

    public function viewPosts()
    {
        $posts = Post::with('category')->where('views', '>', 0)->orderBy('id', 'desc')->get();

         return new PostResource($posts);
        // return response()->json([
        //     'success' => true,
        //     'posts' => $posts,
        // ]);
    } 

    public function getPostById(Post $posts)
    {
        $posts->views = $posts->views + 1;
        $posts->save();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);

    }

    public function getPostByCategory($id)
    {
        //$post = Post::find($id);
         $posts = Post::with('category')->where('id', $id)->orderBy('id', 'desc')->get();

        // return new PostResource($post);
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    public function searchPost($search)
    {
        $posts = Post::with('category')->where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($posts) {
            return response()->json([
                'success' => true,
                'posts' => $posts
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'posts not found'
            ]);
        }
    }
}
