<?php

namespace App\Http\Controllers;

use App\Collection;
use App\User;
use App\Image;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAuthor()
    {

        //$collections = Collection::all();
        return view('self.Collections');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('self.NewCollection');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    //API ROUTES FUNCTIONS
    public function apiStore (Request $request) {
        dd($request);
    }
    public function apiIndexAuth () {

        $collections = auth()->user()->collections;

        foreach ($collections as $collection){
            $collection['items'] = $collection->items;

        }
        return $collections;
    }

    public function apiShow(Collection $collection){
        $collection['items'] = $collection->items;

        return $collection;

    }

    public function apiDelete (Collection $collection) {

        return $collection;


    }

    public function myCollections() {

        

        if (auth()->user()) {
            $collections = auth()->user()->collections;

            foreach ($collections as $collection) {
                $collection['img_url'] = Image::$imageCollectionDefault;
                $collection['loved'] = false;
                $collection['likes'] = 0;
                // $collection['image'] = 'https://fakeimg.pl/350x200/ff0000,128/000,255';
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
}
