<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SectionAssignmentAnswer;
use Illuminate\Http\Request;

class SectionAssignmentAnswerController extends Controller
{


    public function section_assignment_answers($id)
    {
        $assignments = SectionAssignmentAnswer::where('section_assignment_id', $id)->get();
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

        SectionAssignmentAnswer::create($data);

        return [
            'status' => 'answer stored'
        ];
    }


}

