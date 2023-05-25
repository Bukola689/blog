<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
     /**
     * Display post by category of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getPostByCategpory(Request $request)
     {
        $category_id = $request->query('category_id');

        $post = Post::whereHas('category', function($query) use($category_id) {
            $query->where('category_id', $category_id);
        })->get();

        if(!$post) {
            return response()->json('Post category Not found');
        }

        return response()->json($post);
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $post_query = Post::with('category');

       

        if($request->keyword) {
            $post_query->where('name', 'LIKE', '%', $request->keyword, '%');
        }

        if($request->category) {
            $post_query->whereHas('category', function($query) use($request) {
                $query->where('name', $request->category);
            });
        }

         $posts = $post_query->orderBy('id', 'desc')->get();

        return response()->json([
            'message' => 'blog fetch successfully',
            'post' => $posts
        ]);


        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalPost()
    {
        $posts = Post::count();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $image = $request->image;
      
        $originalName = $image->getClientOriginalName();
    
        $image_new_name = 'image-' .time() .  '-' .$originalName;
    
        $image->move('posts/image', $image_new_name);

        $post = new Post;
        $post->category_id = $request->input('category_id');
        $post->title = $request->input('title');
        $post->image = 'posts/image/' . $image_new_name;
        $post->description = $request->input('description');
        $post->views = $request->input('views');
        $post->date = $request->input('date');
        $post->save();


        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json('post not found');
        }

        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request,  $id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json('post not found');
        }

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('posts/image', $image_new_name);
  
            $post->image = 'posts/image/' . $image_new_name;
      }

        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->views = $request->views;
        $post->date = $request->date;
        $post->update();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json('post not found');
        }

        $post = $post->delete();

        return response()->json([
            "message" => 'Post deleted successfully !',
            'post' => $post
        ]);
    }

    public function search($search)
    {
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
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
