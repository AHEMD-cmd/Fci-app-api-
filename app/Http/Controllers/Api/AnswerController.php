<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use App\Models\Quistion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{


    public function index()
    {
        return [
            "answers" => Answer::all()
        ];
    }



    public function store(Request $request)
    {

        $result  = 0 ;

        $answer_data = $request->answer;

        $quistions  = Quistion::where('quiz_id',$answer_data['quiz_id'])->get();

        foreach($quistions as $quistion){

            foreach($answer_data['quistions'] as $answer){

                if($answer['id'] == $quistion->id){

                    if($answer['answer'] == $quistion->answer){

                        $result++ ;
                    }
                }
            }

        }

        $answer = Answer::create([
            'student_mark' => $result,
            'user_id' => $answer_data['user_id'],
            'quiz_id' => $answer_data['quiz_id'],
            'course_id' => $answer_data['course_id']
        ]);

        return [
            'data' => $answer,
            'result' => $result
        ];

    }//end of the function

    public function show($id)
    {

        $answer = Answer::findorfail($id);
        return $answer;

    }




    public function update(Request $request, $id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

            $answer = Answer::findorfail($id);

            $answer->update([
                'student_mark' => $request->student_mark,
                'course_id' => $request->course_id,
                'quiz_id' => $request->quiz_id,
                'user_id' => $request->user_id,
            ]);

            return [
                'data' => $answer,
                'status' => 'done'
            ];

        }


    }


    public function destroy($id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

        $answer = Answer::findorfail($id);
        $answer->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }}
}
