<?php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{

    public function __construct(){

        $this->middleware('auth:sanctum')->except('store');
    }



    public function index()
     {
         return Staff::with('department')->get();
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

        $data = $request->except('img', 'password');

         if($request->hasFile('img')){
            $file = $request->file('img');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('staff_photo/'),$imageName);
            $data['img'] = $imageName;
        }else{
            $data['img'] = public_path('staff_photo/staff.jpg');
        }

        $data['password'] = Hash::make($request->post('password'));

         $staff = Staff::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'img' => $data['img'],
            'phone' => $data['phone'],
            'department_id' => $data['department_id'],
            'type' => $data['type'],
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

            $Staff = Staff::findorfail($id);
            return $Staff;
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

         $Staff = Staff::findorfail($id);

         $data = $request->except('img', 'password');


        if($request->hasFile('img')){
            $file = $request->file('img');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('staff_photo/'),$imageName);
            $data['img'] = $imageName;
        }else{
            $data['img'] = $Staff->img;
        }

        $data['password'] = Hash::make($request->post('password'));

       $Staff->update([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'img' => $data['img'],
        'phone' => $data['phone'],
        'department_id' => $data['department_id'],
        'type' => $data['type'],
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

         $student = Staff::findorfail($id);
         $student->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
    }
}
