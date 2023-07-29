<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\All_quistion;
use App\Models\Answer_all_quiz;
use Illuminate\Http\Request;

class AnswerAllQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            "answers" => Answer_all_quiz::all()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = 0;

        $answer_data = $request->answer;

        $quistions = All_quistion::where('all_quiz_id', $answer_data['quiz_id'])->get();

        foreach($quistions as $quistion){

            foreach($answer_data['quistions'] as $answer){

                if($answer['id'] == $quistion->id){

                    if($answer['answer'] == $quistion->answer){

                        $result++ ;
                    }
                }
            }

        }

        Answer_all_quiz::create([
            'user_id' => $answer_data['user_id'],
            'all_quiz_id' => $answer_data['quiz_id'],
            'course_id' => $answer_data['course_id'],
            'student_mark' => $result,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
