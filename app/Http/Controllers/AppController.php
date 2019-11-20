<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Collection;
use App\Image;

class AppController extends Controller
{

    // HOME PUBLIC VIEW APP
    // public function vueHome()
    // {
    //     return view ('app.public.home');
    // }
    public function collectionShow()
    {
        return view ('app.public.collection');
    }


    public function apiHome() {

        //TODO IF AUTH ONLY USER CATEGORIES

        $categories = Category::all();

        // foreach ($categories as $category) {
        //     $category['collections'] = $category->collections;

        // }

        return $categories;
    }
    // TODO AT MODEL
    public function apiCategoriesFromUser(User $user) {

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
        // $image = '/storage/collect-125-79003.png';
        $image = '';
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

