<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Collection;
use App\Image;

class AppController extends Controller
{



    public function apiHome() {

        
        $categories = Category::all();

        

        return $categories;
    }

   

    public function apiCollectionsByCotegory(Category $category) {
        $collections = $category->collections;

        //TODO IF AUTH ONLY USER CATEGORIES
        if (auth()->user()){



            foreach ($collections as $collection) {

                $collection['author'] = false;
                $collection['loved'] = false;
                $collection['likes'] = 0;
                
                $collection['img_url'] = Image::$imageCollectionDefault ;

                if($collection->image) {
                  $collection['img_url'] = $collection->image->url;
                }


                if($collection->user->id == auth()->user()->id){

                    $collection['author'] = true;

                }
                if($collection->collectionLovedByUser($collection)){
                    $collection['loved'] = true;
                }
                if($collection->lovedByUsers()){
                    $collection['likes'] = $collection->lovedByUsers()->count();
                }
            }
        }
        return response()->json($collections);
    }

    public function destroy(Collection $collection)
    {

        $collection->delete();

    }

    public function Show($collection) {

        $collection = Collection::all()->find($collection);
        $items = '';
            if ($collection->items) {
             $items = $collection->items;
             foreach ($items as $item) {
                $item['img_url'] = Image::$imageItemDefault;
                 if($item->image){
                 $item['img_url'] = $item->image->url;
                }
             }
            }
        
        $image = Image::$imageCollectionDefault;
        if ($collection->image) {
            $image = $collection->image->url;
        // dd($image);
        }
        $category = $collection->category;
       // $collection['items'] = $items;
        $collection['category'] = $category;
       
        
        return response()->json([
            'collection' => $collection,
            'image' => $image,
            ]);

    }

    public function apiCollectionsFromCategories(Array $categories){

    }
}

