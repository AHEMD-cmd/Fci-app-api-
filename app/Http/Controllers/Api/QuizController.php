<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Quistion;
use App\Models\active_quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    public function index()
    {
        return Quiz::with('quistions')->get();
    }




    public function store(Request $request)
    {

        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $Quiz = Quiz::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'max_degree' => $request->max_degree,
            'max_time' => $request->max_time,
            'instructor' => $request->instructor,
        ]);

        active_quiz::create([
            'quiz_id' => $Quiz->id,
            'start_date' => $Quiz->created_at,

        ]);

        return[
            'data' => $Quiz
        ];
    }
    }



    public function show($id)
    {

        $Quiz = Quiz::findorfail($id);
        $Quiz->load('quistions');

        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addMinute($Quiz->max_time);

        if($currentDateTime > $Quiz->created_at && $newDateTime > $currentDateTime){

            return $Quiz;
        }

        return "not allowed";

    }




    public function update(Request $request, $id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $Quiz = Quiz::findorfail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'course_id' => 'required|exists:courses,id',
            'max_degree' => 'required',
            'max_time' => 'required',
            'instructor' => 'required',

        ]);

      $Quiz->update($data);

      return[
          'data' => $Quiz
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
        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $Quiz = Quiz::findorfail($id);
        $Quiz->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }
}
}
