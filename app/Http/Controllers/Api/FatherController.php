<?php

namespace App\Http\Controllers\Api;

use App\Models\Father;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FatherController extends Controller
{

    public function __construct(){

        $this->middleware('auth:sanctum')->except('store');
    }

   public function index()
     {
         return Father::all();
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
        // return $request;

        $data = $request->except('password');

        $data['password'] = Hash::make($request->post('password'));

         $staff = Father::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],

         ]);

         return[
             'data' => $staff
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
        if(Auth::guard('sanctum')->user()->id == $id){

            $Staff = Father::find($id);
            return $Staff;
        }else{
            return 'you have to be the owner of the email';
        }
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {

        if(Auth::guard('sanctum')->user()->id == $id){

         $Staff = Father::findor($id);

         $data = $request->except('password');




        $data['password'] = Hash::make($request->post('password'));

       $Staff->update([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'phone' => $data['phone'],
     ]);

       return[
           'data' => $Staff
       ];
    }
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
        if(Auth::guard('sanctum')->user()->id == $id){

         $student = Father::find($id);
         if(!$student){
            return 'this student does not exist';
         }
         $student->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
    }
}
