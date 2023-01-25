<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Post;
// use App\Models\User;

class Comment extends Model
{
    use HasFactory;

   // protected $guarded = [];

    public function post() // post_id
    {
        return $this->belongsTo(Post::class);
    }

    public function author() //laravel woutld think it's author_id which is false
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
