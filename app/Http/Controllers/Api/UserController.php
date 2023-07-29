<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

            $this->middleware('staff_check')->except('store', 'update','delete','show');
            $this->middleware('auth:sanctum')->except('store');

    }

    public function index()
    {
        return User::all();
    }



    public function store(Request $request)
    {

        $data = $request->except('img');

        if($request->hasFile('img')){
           $file = $request->file('img');
           $imageName = time().'_'. $file->getClientOriginalName();
           $file->move(\public_path('user_img/'),$imageName);
           $data['img'] = $imageName;
       }else{
        $data['img'] = public_path('user_img/mr_robot.jpg');
       }

       if($data['password'] == $data['password_confirmation']){

           $data['password'] = Hash::make($request->post('password'));
           $data['password_confirmation'] = Hash::make($request->post('password_confirmation'));
       }else{
        return [
            'status' => "password not match"
        ];
       }

        $student = User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'img' => $data['img'],
            'phone' => $data['phone'],
            'department_id' => $data['department_id'],
            'ssn' => $data['ssn'],
            'password_confirmation' => $data['password_confirmation'],
            'parent_phone' => $data['parent_phone'],
            'university_email' => $data['university_email'],
        ]);

        return[
            'data' => $student
        ];
    }




    public function show(Request $request, $id)
    {
        if(Auth::guard('sanctum')->user()->id == $id){

            $user = User::findorfail($id);
            return $user->load('courses');
        }
    }




    public function update(Request $request, $id)
    {

        if(Auth::guard('sanctum')->user()->id == $id){

        $student = User::findorfail($id);

       $data = $request->except('img', 'password');

       if($request->hasFile('img')){
           $file = $request->file('img');
           $imageName = time().'_'. $file->getClientOriginalName();
           $file->move(\public_path('user_img/'),$imageName);
           $data['img'] = $imageName;
       }else{
           $data['img'] = $student->img;
       }

    $data['password'] = Hash::make($request->post('password'));


      $student->update([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'img' => $data['img'],
        'ssn' => $data['ssn'],
        'phone' => $data['phone'],
        'department_id' => $data['department_id'],
        'parent_phone' => $data['parent_phone'],
            'university_email' => $data['university_email'],
    ]);

      return[
          'data' => $student
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

        $user = User::findorfail($id);
        $user->delete();

        return[
            'data' => $user
        ];

    }}
}
