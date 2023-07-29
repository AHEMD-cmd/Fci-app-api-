<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureAssignment;
use Illuminate\Support\Facades\Auth;

class LectureAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lecture_assignments($id)
    {
        $assignments = LectureAssignment::where('course_id', $id)->get();
        return [
            "assignment" => $assignments
        ];
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

        $data = $request->validate([
            'title' => 'required|string',
            'desc' => 'required|string',
            'file' => 'nullable',
            'course_id' => 'exists:courses,id'
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('lectures_assignments_files/'),$fileName);
            $data['file'] = $fileName;
        }
        $Assignment = LectureAssignment::create($data);

        return [
            'data' => $Assignment
        ];
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = LectureAssignment::findOrFail($id);
        // $assignment->load('answers');
        return [
            'assignment' => $assignment
        ];
    }


    public function update(Request $request, $id)
    {

        $assignment = LectureAssignment::findorfail($id);

        if(Auth::guard('sanctum')->user()->type == 'doc'){


        $data = $request->except('file');

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('lectures_assignments_files/'),$fileName);
            $data['file'] = $fileName;
        }else{
            $data['file'] = $assignment->file;
        }

       $assignment->update($data);

       return[
           'data' => $assignment
       ];
    }else{
        return 'you are not allowed';
    }
    }


    public function destroy($id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){
        $assignment = LectureAssignment::findOrFail($id);
        $assignment->delete();
        return [
            'status' => 'assignment deleted'
        ];
    }
  }
}
