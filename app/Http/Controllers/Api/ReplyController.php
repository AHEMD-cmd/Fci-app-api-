<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{


    public function index()
     {
         return Reply::all();
     }




     public function store(Request $request)
     {

         $data = $request->validate([
             'post_id' => 'required|string|max:250|exists:posts,id',
             'user_id' => 'required|string|max:250|exists:users,id',
             'content' => 'required|string|max:2000',

         ]);



         $Reply = Reply::create($data);

         return[
             'data' => $Reply
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
        $reply = Reply::findorfail($id);
        return $reply;

     }





     public function update(Request $request, $id)
     {

         $reply = Reply::findorfail($id);

        if(Auth::guard('sanctum')->user()->id == $reply->user_id){

       $reply->update([
        'post_id' => $request->post_id,
        'user_id' => $request->user_id,
        'content' => $request->content,
       ]);

       return[
           'data' => $reply
       ];
     }
    }





     public function destroy($id)
     {

         $reply = Reply::findorfail($id);


        if(Auth::guard('sanctum')->user()->id == $reply->user_id){


         $reply->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
}
}
