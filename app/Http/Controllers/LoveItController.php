<?php

namespace App\Http\Controllers;

use App\LoveIt;
use App\User;
use App\Collection;
use Auth;
use Illuminate\Http\Request;

class LoveItController extends Controller
{
    public function attachLoveCollectionUser(Request $request)
    {
        $user = Auth::user();
        $collection = Collection::find($request);
        $collection[0]->lovedByUsers()->attach($user->id);
   }
   public function detachLoveCollectionUser(Request $request)
   {
        $user = Auth::user();
        $collection = Collection::find($request);
        $collection[0]->lovedByUsers()->detach($user->id);
   }
}
