<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Quistion;
use App\Models\active_quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Active_all_quiz;
use App\Models\All_quistion;
use App\Models\All_quiz;
use App\Models\perm_attendance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AllQuizController extends Controller
{



    public function index()
    {
        return All_quiz::with('quistions')->get();
    }




    public function store(Request $request)
    {

        if(Auth::guard('sanctum')->user()->type == 'doc'){


        $Quiz = $request->quiz;
        // $Quiz = json_decode($request->quiz, true);

        $data = All_quiz::create([
            'name' => $Quiz['name'],
            'course_id' => $Quiz['course_id'],
            'max_degree' => $Quiz['max_degree'],
            'max_time' => $Quiz['max_time'],
            'instructor' => $Quiz['instructor'],
        ]);

        // return $Quiz['quistion'];
        for ($i =0; $i <= count(array($Quiz['quistion'])); $i++){
// return ;
            $quistions = All_quistion::create([
                'quistion' => $Quiz['quistion'][$i]['quistion'],
                'answer' => $Quiz['quistion'][$i]['answer'],
                'option1' => $Quiz['quistion'][$i]['option1'],
                'option2' => $Quiz['quistion'][$i]['option2'],
                'option3' => $Quiz['quistion'][$i]['option3'],
                'option4' => $Quiz['quistion'][$i]['option4'],
                'option5' => $Quiz['quistion'][$i]['option5'],
                'all_quiz_id' => $data->id
            ]);
            // return 0;
        }



        Active_all_quiz::create([
            'all_quiz_id' => $data->id,
            'start_date' => $data->created_at,

        ]);

        return[
            'data' => $data->load('quistions')
        ];
    }
    }



    public function show($id)
    {
        $user = perm_attendance::where('user_id', Auth::guard('sanctum')->user()->id)->latest()->first();
        if($user){


        if($user->created_at > Carbon::yesterday() && $user->created_at < Carbon::tomorrow() ){

        $Quiz = All_quiz::findorfail($id);
        $Quiz->load('quistions');

        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addMinute($Quiz->max_time);

        if($currentDateTime > $Quiz->created_at && $newDateTime > $currentDateTime){

            return $Quiz;
        }

    }else{
        return [
            'status' => 'you are not allowed'
        ];
    }

        }elseif(Auth::guard('sanctum')->user()->type == 'doc'){

            $Quiz = All_quiz::findorfail($id);
            $Quiz->load('quistions');
            return $Quiz;

        }else{

            return "not allowed";
        }


    }




    public function update(Request $request, $id)
    {

        $Quiz = All_quiz::findorfail($id);


    if(Auth::guard('sanctum')->user()->type == 'doc'){

        $data = $request->quiz;

        $Quiz->update([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'max_degree' => $data['max_degree'],
            'max_time' => $data['max_time'],
            'instructor' => $data['instructor'],

        ]);

        for ($i =0; $i <= count(array($data['quistion'])); $i++){

            $quistions = All_quistion::where('all_quiz_id', $Quiz->id)->get();
            foreach($quistions as $quistion){
                $quistion->update([
                    'quistion' => $data['quistion'][$i]['quistion'],
                    'answer' => $data['quistion'][$i]['answer'],
                    'option1' => $data['quistion'][$i]['option1'],
                    'option2' => $data['quistion'][$i]['option2'],
                    'option3' => $data['quistion'][$i]['option3'],
                    'option4' => $data['quistion'][$i]['option4'],
                    'option5' => $data['quistion'][$i]['option5'],
                    'all_quiz_id' => $Quiz->id,
                ]);
            }


        }

        return[
            'data' => $Quiz->load('quistions')
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

        $Quiz = All_quiz::findorfail($id);
        $Quiz->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }
}
}
