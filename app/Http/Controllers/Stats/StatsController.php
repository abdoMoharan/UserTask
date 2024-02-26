<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function  countUsers(){
        $users = User::count();
        return response()->json($users);
    }

    public function  countPosts(){
        //$posts=auth()->user()->posts;
        $posts= Post::count();
        return response()->json($posts);
    }


    public function  countPostUser(Request $request){
        $posts= Post::where('user_id',$request->user_id)->count();
        return response()->json($posts);
    }
}
