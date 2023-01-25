<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

// 3 waays to Mitigate Mass Assignment Vulnerabilities

 //   protected $guarded = []; //this doesn't allow mass assignment
    protected $guarded = ['id']; //id is not fillable
 //   protected $fillable = ['title', 'slug','excerpt', 'body', 'category_id'];

    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters)// Post::newQuery()->filter()
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['category'] ?? false, fn($query, $category) => 
            $query->whereHas('category', fn($query) => 
                $query->where('slug', $category)
            )
        );

         $query->when($filters['author'] ?? false, fn($query, $author) => 
            $query->whereHas('author', fn($query) => 
                $query->where('username', $author)
            )
        );
      
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function comments() //author_id
    {
        // hasOne, hasMany, belongsTo, belongsMany
        return $this->hasMany(Comment::class); //User model class? foreign_id
    }


    public function category()
    {
        // hasOne, hasMany, belongsTo, belongsMany
        return $this->belongsTo(Category::class);
    }

     public function author() //author_id
    {
        // hasOne, hasMany, belongsTo, belongsMany
        return $this->belongsTo(User::class, 'user_id'); //User model class? foreign_id
    }
}
