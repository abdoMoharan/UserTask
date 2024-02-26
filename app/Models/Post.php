<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['title', 'body','image','user_id','stats'];
   //relationships

    public function user(){
        return $this->belongsTo(User::class);
    }

   public function tags()
   {
    return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tags_id');
   }

   public function getImageAttribute($value)
   {
       if ($value)
           return asset('attachments/' . $value);

       else
           return null;
   }

   public function setImageAttribute($value)
   {
       if ($value) {
           $this->attributes['image'] = $value->store('post', 'attachment');
       }
   }
}
