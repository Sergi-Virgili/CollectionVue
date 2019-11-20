<?php

namespace App\Http\Controllers;

Use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(int $id)
    {
        $user = User::all()->find($id);
        $collections = $user->collections;
        return response()->json(['user' => $user, 'collections' => $collections]);
    }

    public function user(int $id)
    {
        $user = User::find($id);
        $user['isUserProfile'] = false;
        if($user->id == auth()->user()->id){
            $user['isUserProfile'] = true;
        }

        return response()->json($user);
    }
    public function updateUser(Request $request, Int $id)
    {
        $user = User::find($id);
        $user->update($request->all());
    }
}
