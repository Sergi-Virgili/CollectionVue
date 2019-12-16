<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   
    public function index()
    {
        $categories=Category::all();
        return view ('public.catalog', ['categories' => $categories]);
    }

  
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        if($request->icon){
        $newimage = new Image();
        $newimage->storeImageCategory($request, $category->id);
        };
    }

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
    public function updateCategory(Request $request, $category)
    {
        $category = Category::find($category);
        if($request->icon){
            $newimage = new Image();
            $newimage->storeImageCategory($request, $category->id);
            }
            $category->update($request->all());
    }

  
    public function deleteCategory(Int $id)
    {
        $category = Category::find($id);
        $category->delete();
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

   public function apiHome() {

        
    $categories = Category::all();
  

    return $categories;
    }





}
