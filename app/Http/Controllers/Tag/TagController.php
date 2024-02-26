<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tag\TagsRequest;

class TagController extends Controller
{
    public function index(Request $request){


        $tags = Tag::query()->with('user')->where('user_id', $request->user()->id)->get();
        return  TagsResource::collection($tags);
    }


    public function store(TagsRequest $request){
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $tag = Tag::create($data);
        return TagsResource::make($tag);
    }


    public function show($id){
        $tag = Tag::findOrFail($id);
        $tag->load('user');
        return TagsResource::make($tag);
    }


    public function update(TagsRequest $request, $id){
        $tag = Tag::findOrFail($id);
        $tag->update($request->validated());
        return TagsResource::make($tag);
    }


    public function destroy($id){
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return response()->json(['message' => 'tags is deleted'], 204);
    }
}
