<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        if($categories->isEmpty()) {
            return response()->json('Category are Empty');
        }

        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalCategory()
    {
        $categories = Category::count();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $categories = new Category;
        $categories->name = $request->input('name');
        $categories->save();

        return new CategoryResource($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json('Category not found');
        }


        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json('Category not found');
        }

        $category->name = $request->input('name');
        $category->update();

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json('Category not found');
        }

        $category = $category->delete();

        // return new CategoryResource($category);
 
        return response()->json([
         "message" => 'Catgeory deleted successfully !',
         'category' => $category
       ]);

    }

    public function search($search)
    {
        $categories = Category::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($categories) {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'categories not found'
            ]);
        }
    }
}
