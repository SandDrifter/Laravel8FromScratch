<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class Post
{
	public $title;

	public $excerpt;

	public $date;

	public $body;

	public $slug; 

	public function __construct($title, $excerpt, $date, $body, $slug)
	{
		$this->title = $title;
		$this->excerpt = $excerpt;
		$this->date = $date;
		$this->body = $body;
		$this->slug = $slug;
	}

	public static function all(){
		return cache()->rememberForever('posts.all', function(){
			return collect(File::files(resource_path("posts")))
			    ->map(function($file){
			        return YamlFrontMatter::parseFile($file);
			    })
			    ->map(function($document){
			        return new Post(
			            $document->title,
			            $document->excerpt,
			            $document->date,
			            $document->body(),
			            $document->slug
			        );
			    })
			    ->sortByDesc('date');
		});

		
	}

	public static function find_old($slug){
		// of all the blog posts, find the one with a slug that matches the one that was requested.

	   // $path = __DIR__."/../resources/posts/{$slug}.html";
	    $path = resource_path("posts/{$slug}.html");

		//echo($path);
		//ddd($path);

	    if(!file_exists($path)){
	       // dd('File does not exists'); //die dump
	        //ddd('File does not exists'); // die dump debug
	       // abort(404);// 404 page
	       // return redirect('/');
	    	throw new ModelNotFoundException();
	    }

	    $post = cache()->remember("posts.{slug}", now()->addMinutes(1), function() use ($path){
	      //  var_dump('file_get_contents');
	        return file_get_contents( $path);
	    });

	    //$post = file_get_contents( $path);
	    
	    return view('post', [
	        'post' => $post
	    ]);
	}


	public static function find($slug){
		// of all the blog posts, find the one with a slug that matches the one that was requested
		$post = static::all()->firstWhere('slug', $slug);

		return $post;
	}

	public static function findOrFail($slug){
		// of all the blog posts, find the one with a slug that matches the one that was requested
		$post = static::find($slug);

		if(! $post){
			throw new ModelNotFoundException();
		}

		return $post;
	}

}

?>