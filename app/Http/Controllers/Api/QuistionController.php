<?php

namespace App\Http\Controllers\Api;

use App\Models\Quistion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuistionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Quistion::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $quistion = Quistion::create([
            'quistion' => $request->quistion,
            'answer' => $request->answer,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
            'option5' => $request->option5,
            'quiz_id' => $request->quiz_id,


        ]);

        return[
            'data' => $quistion,
            'status' => 'success'
        ];
    }
    }



    public function show($id)
    {
        $department = Quistion::findorfail($id);
        return $department;
    }




    public function update(Request $request, $id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $quistion = Quistion::findorfail($id);

        $data = $request->validate([
            'quistion' => 'required|string|max:1000',
            'answer' => 'required|string|max:1000',
            'option1' => 'required|string|max:1000',
            'option2' => 'required|string|max:1000',
            'option3' => 'required|string|max:1000',
            'option4' => 'required|string|max:1000',
            'quiz_id' => 'required|exists:quizzes,id',

        ]);

      $quistion->update($data);

      return[
          'data' => $quistion
      ];
    }
    }




    public function destroy($id)
    {

        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $quistion = Quistion::findorfail($id);
        $quistion->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }
}
}
