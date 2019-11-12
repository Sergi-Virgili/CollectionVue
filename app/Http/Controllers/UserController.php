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
}
