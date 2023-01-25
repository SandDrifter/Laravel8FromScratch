<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades;


class PostController extends Controller
{
    //

   public function index()
   {
      //  Gate::allows('admin');
     //   request()->user()->can('admin');
  //  $this->authorize('admin');

        return view('posts.index', [
            'posts' =>  Post::latest()->filter(
                request(['search','category', 'author'])
            )->paginate(6)->withQueryString()
        ]);
   }


   public function show(Post $post){
        return view('posts.show',[
            'post' => $post //Post::findOrFail($id)
        ]);
   }


  

   // 7 RESTful actions
   //index, show, create, store, edit, update, destroy





}
