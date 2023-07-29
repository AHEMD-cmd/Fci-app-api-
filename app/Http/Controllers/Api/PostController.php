<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{


    public function index()
     {
         return Post::with('reply')->get();
     }




     public function store(Request $request)
     {
         $data = $request->validate([
             'title' => 'required|string|max:250',
             'user_id' => 'required|string|max:250|exists:users,id',
             'content' => 'required|string|max:2000',
             'img' => 'required|image',

         ]);

         if($request->hasFile('img')){
            $file = $request->file('img');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('post_photo/'),$imageName);
            $data['img'] = $imageName;
        }


         $post = Post::create($data);

         return[
             'data' => $post
         ];
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {

        $student = Post::findorfail($id);
        return $student;
    }





     public function update(Request $request, $id)
     {


         $post = Post::findOrfail($id);

        if(Auth::guard('sanctum')->user()->id == $post->user_id){


         $data = $request->validate([
            'title' => 'required|string|max:250',
            'user_id' => 'required|string|max:250|exists:users,id',
            'content' => 'required|string|max:2000',
            'img' => 'nullable|image',
        ]);



        if($request->hasFile('img')){
            $file = $request->file('img');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('staff_photo/'),$imageName);
            $data['img'] = $imageName;
        }else{
            $data['img'] = $post->img;
        }

       $post->update($data);

       return[
           'data' => $post
       ];
    }
     }





     public function destroy($id)
     {

        $post = Post::findorfail($id);

        if(Auth::guard('sanctum')->user()->id == $post->user_id){

         $post->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
    }
}

