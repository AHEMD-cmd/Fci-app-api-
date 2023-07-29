<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LectureAssignmentAnswer;

class LectureAssignmentAnswersController extends Controller
{


    public function lecture_assignment_answers($id)
    {
        $assignments = LectureAssignmentAnswer::where('lecture_assignment_id', $id)->get();
        return [
            "assignment answers" => $assignments
        ];
    }



    public function store(Request $request)
    {
        $data = $request->all();

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('lecture_assignments_answers_files/'),$fileName);
            $data['file'] = $fileName;
        }

        LectureAssignmentAnswer::create($data);

        return [
            'status' => 'answer stored'
        ];
    }


}

