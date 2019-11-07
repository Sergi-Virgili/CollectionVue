<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return view ('public.catalog', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        if($request->image){
        $newimage = new Image();
        $newimage->storeImageCategory($request, $category->id);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $collections = $category->collections();
        return view('public.showCategory',['collections' => $collections]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->image){
        $newimage = new Image();
        $newimage->storeImageCategory($request, $category->id);
        }
        $category->update($request->all());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }

    public function adminIndex()
    {
        $categories=Category::all();
        return view ('admin.categories', ['categories' => $categories]);
    }

    public function returnCategoriesDataJSON()
    {
        $categories=Category::all();
        return response()->json($categories);
    }

    public function returnUserCategoryDataJSON()
    {
        $user = Auth::user();
        $userCategories = $user->categories;
        return response()->json($userCategories);
    }

    public function attachCategoryUser(Request $request)
    {
        $user = Auth::user();
        $category = Category::find($request);
        $category[0]->users()->attach($user->id);
   }

   public function detachCategoryUser(Request $request)
   {
       $user = Auth::user();
       $category = Category::find($request);
       $category[0]->users()->detach($user->id);
   }





}
