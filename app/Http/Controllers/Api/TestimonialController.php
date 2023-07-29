<?php

namespace App\Http\Controllers\Api;

use App\Models\Testmonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Testmonial::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',

        ]);

        $department = Testmonial::create($data);

        return[
            'data' => $department
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
        $department = Testmonial::findorfail($id);
        return $department;
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
        $testmonial = Testmonial::findorfail($id);

        if(Auth::guard('sanctum')->user()->id == $testmonial->user_id){

        $data = $request->validate([
            'content' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',

        ]);

      $testmonial->update($data);

      return[
          'data' => $testmonial
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

        $testimonial = Testmonial::findorfail($id);

        if(Auth::guard('sanctum')->user()->id == $testimonial->user_id){

        $testimonial->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }
        }
}
