<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Database\Query\Expression;

class PostController extends Controller
{
    public function index(){
    $posts = Post::query()->with(['user','tags'])->get();

    return PostResource::collection($posts);
    }

    public function store(PostRequest $request){
        try{
            DB::beginTransaction();
            $data = $request->validated();
            $data['user_id'] =  $request->user()->id;
            $post = Post::create($data);
            $post->tags()->attach($data['tags']);
            DB::commit();
            return PostResource::make($post);
        }catch(Expression $e){
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el post'], 500);
        }
    }
    public function show($id){
        $post = Post::findOrFail($id);
        $post->load(['user','tags']);
        return PostResource::make($post);
    }
    public function update(PostRequest $request, $id){


        try{
            DB::beginTransaction();
            $data = $request->validated();
            $post = Post::findOrFail($id);
            $post->update($data);
            $post->tags()->sync($request->tags);
            DB::commit();
            return PostResource::make($post);
        }catch(Expression $e){
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el post'], 500);
        }

    }
    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }



    public function showAllPostDeleted(){
        $deletedPosts = Post::onlyTrashed()->get();
        return PostResource::collection($deletedPosts);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();

        return response()->json(['message' => 'success'],200);
    }


}
