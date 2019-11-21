<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Item;
use App\Category;
use App\User;
use App\Image;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
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

    public function Show($collection) {

        $collection = Collection::all()->find($collection);
        if(!$collection) { 
            return null;
        }
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
       
        }
        $category = $collection->category;
       
        $collection['category'] = $category;
       
        
        return response()->json([
            'collection' => $collection,
            'image' => $image,
            ]);

    }

    public function store(Request $request)
    {
        
        $collection = new Collection();
        $collection->name = $request->name;
        $collection->category_id = $request->category_id;
        $collection->description = $request->description;
        $collection->user_id = auth()->user()->id;
        $collection->save();
        
        if($request->image){
            $newimage = new Image();
            $newimage->storeImageCollection($request, $collection->id);
        }
        return $collection;
    }
    
    public function updateCollection(Request $request)
    {
        
        $collection = Collection::find($request->id);
        
       
        // TODO $collection->image->destroy();
        if($request->image){

            $newimage = new Image();

            $newimage->storeImageCollection($request, $collection->id);
            
            }
            

            $collection->update($request->all());

        
    }

    
    public function destroy(Collection $collection)
    {

        $collection->delete();

    }

    // public function apiIndexAuth () {

    //     $collections = auth()->user()->collections;

    //     foreach ($collections as $collection){
    //         $collection['items'] = $collection->items;

    //     }
    //     return $collections;
    // }

    // public function apiShow(Collection $collection){
    //     $collection['items'] = $collection->items;

    //     return $collection;

    // }

    // public function apiDelete (Collection $collection) {

    //     return $collection;


    // }

    public function myCollections() {

        if (auth()->user()) {
            $collections = auth()->user()->collections;

            foreach ($collections as $collection) {
                $collection['img_url'] = Image::$imageCollectionDefault;
                $collection['loved'] = false;
                $collection['likes'] = 0;
                
                $collection['author'] = true;

                if ($collection->image) {
                $collection['img_url'] = $collection->image->url;
                }
                if($collection->collectionLovedByUser($collection)){
                    $collection['loved'] = true;
                }
                if($collection->lovedByUsers()){
                    $collection['likes'] = $collection->lovedByUsers()->count();
                }
               
            }

            }
            
            return $collections;
        
    }
    public function myFavorites(){
        if (auth()->user()) {
            $user = auth()->user();
            $collections = $user->loveCollections;
            foreach ($collections as $collection) {
                $collection['img_url'] = Image::$imageCollectionDefault;
                $collection['loved'] = true;
                $collection['likes'] = 0;
               if ($collection->image) {
                $collection['img_url'] = $collection->image->url;
                }
                
                $collection['likes'] = $collection->lovedByUsers()->count();
                
            }
            return response()->json($collections);
        }
    }
}