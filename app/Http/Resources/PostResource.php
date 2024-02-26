<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TagsResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->whenNotNull($this->image),
            'user' => UserResource::make($this->whenLoaded('user')),
            'tags' => TagsResource::collection($this->whenLoaded('tags')),
        ];
    }
}
