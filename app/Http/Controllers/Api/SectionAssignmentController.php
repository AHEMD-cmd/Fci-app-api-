<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SectionAssignment;
use Illuminate\Support\Facades\Auth;

class SectionAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function section_assignments($id)
    {
        $assignments = SectionAssignment::where('course_id', $id)->get();
        return [
            "assignments" => $assignments
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
        if(Auth::guard('sanctum')->user()->type == 'assis' ){

        $data = $request->validate([
            'title' => 'required|string',
            'desc' => 'required|string',
            'file' => 'nullable',
            'course_id' => 'exists:courses,id'
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('section_assignments_files/'),$fileName);
            $data['file'] = $fileName;
        }
        $Assignment = SectionAssignment::create($data);

        return [
            'data' => $Assignment
        ];
    }else{
        return 'youa are not an assistant';
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
        $assignment = SectionAssignment::findOrFail($id);
        // $assignment->load('answers');
        return [
            'assignment' => $assignment
        ];
    }


    public function update(Request $request, $id)
    {

        $assignment = SectionAssignment::findorfail($id);

        if(Auth::guard('sanctum')->user()->type == 'assis' ){


        $data = $request->except('file');

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('section_assignments_files/'),$fileName);
            $data['file'] = $fileName;
        }else{
            $data['file'] = $assignment->file;
        }

       $assignment->update($data);

       return[
           'data' => $assignment
       ];
    }
    }


    public function destroy($id)
    {
        if(Auth::guard('sanctum')->user()->type == 'assis' ){
        $assignment = SectionAssignment::findOrFail($id);
        $assignment->delete();
        return [
            'status' => 'assignment deleted'
        ];
    }
  }
}
