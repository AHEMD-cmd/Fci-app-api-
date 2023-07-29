<?php

namespace App\Http\Controllers\api;

use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LecturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course_lectures($code)
    {
        $lectures = Lecture::where('code', $code);
        return [
            "lectures" => $lectures
        ];
    }


    public function store(Request $request)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc'){

            $data = $request->validate([
                'title' => 'required|string',
                'file' => 'nullable',
                'code' => 'exists:courses,id'
            ]);

            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = time().'_'. $file->getClientOriginalName();
                $file->move(\public_path('lectures_files/'),$fileName);
                $data['file'] = $fileName;
            }
            $Assignment = Lecture::create($data);

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
        $lecture = Lecture::findOrFail($id);
        return [
            'lecture' => $lecture
        ];
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

        $assignment = Lecture::findorfail($id);

        if(Auth::guard('sanctum')->user()->type == 'doc'){


        $data = $request->except('file');

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('assignments_files/'),$fileName);
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guard('sanctum')->user()->type == 'doc' ){
        $assignment = Lecture::findOrFail($id);
        $assignment->delete();
        return [
            'status' => 'assignment deleted'
        ];
    }
  }
}
