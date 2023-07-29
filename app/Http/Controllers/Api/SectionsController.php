<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course_sections($id)
    {
        $lectures = Section::where('course_id', $id);
        return [
            "sections" => $lectures
        ];
    }


    public function store(Request $request)
    {
        if(Auth::guard('sanctum')->user()->type == 'assis'){

            $data = $request->validate([
                'title' => 'required|string',
                'file' => 'nullable',
                'course_id' => 'exists:courses,id'
            ]);

            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = time().'_'. $file->getClientOriginalName();
                $file->move(\public_path('section_files/'),$fileName);
                $data['file'] = $fileName;
            }
            $Assignment = Section::create($data);

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
        $lecture = Section::findOrFail($id);
        return [
            'section' => $lecture
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

        $assignment = Section::findorfail($id);

        if(Auth::guard('sanctum')->user()->type == 'assis'){


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
    }else{
        return 'you are not assis';
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
        if(Auth::guard('sanctum')->user()->type == 'assis' ){
        $assignment = Section::findOrFail($id);
        $assignment->delete();
        return [
            'status' => 'section deleted'
        ];
    }
  }
}
