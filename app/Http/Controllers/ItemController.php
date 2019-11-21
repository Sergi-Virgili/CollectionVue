<?php

namespace App\Http\Controllers;

use App\Item;
use App\Image;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('public.itemsList',['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        
        $item = new Item;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->collection_id = $request->collection_id;
       // dd($item);
        $item->save();
       // return $item->id;
        if ($request->image) {
            $image = new Image;
            $image->storeImageItem($request, $item->id);
        }


        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(int $item)
    {
        $item = Item::all()->find($item);

        return response()->json($item);

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request)
    {
         
         $item = Item::find($request->id);
        
         // $collection->image->destroy();
         if($request->image){
 
             $newimage = new Image();
 
             $newimage->storeImageItem($request, $request->id);
             
             }
             
 
             $item->update($request->all());
 
         //return redirect('home/'.'Collections');
     }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    function destroy(Item $item)
    {
        $item->delete();
        return 'item deleted';
    }
}
