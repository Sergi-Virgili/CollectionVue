<?php

namespace App\Http\Controllers;

use App\LoveIt;
use App\User;
use Illuminate\Http\Request;

class LoveItController extends Controller
{
    public function show(int $id)
    {
        $user = User::all()->find($id);
        $loveit = $user->loveit();
        $collections = $loveit->collections;
        return response()->json(['user' => $user, 'collections' => $collections]);
    }
}
