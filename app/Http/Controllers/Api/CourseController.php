<?php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course_Staff;
use App\Models\Course_User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct(){

        $this->middleware('staff_check')->except('index', 'show', 'user_delete_course', 'user_course');
    }


    public function index($level, $term)
    {
        return Course::where('level', $level)->where('term', $term)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request;
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'term' => 'required|string|max:100',
            'level' => 'required|string|max:20',
            'hours' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'img' => 'required',

        ]);

            if($request->hasFile('img')){
                $file = $request->file('img');
                $imageName = time().'_'. $file->getClientOriginalName();
                $file->move(\public_path('course_imgs/'),$imageName);
                $data['img'] = $imageName;
            }

        $course = Course::create($data);

        $course_staff = Course_Staff::create([
            'course_id' => $course->id,
            'staff_id' => Auth::guard('sanctum')->user()->id,
        ]);

        return[
            'data' => $course
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::findorfail($id);

        return $course;
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

        $course = Course::findorfail($id);

        $staff_id = Course_Staff::where('course_id',$course->id)->first();
        $user_id= $staff_id->staff_id;


            if($request->hasFile('file')){
                $file = $request->file('file');
                $imageName = time().'_'. $file->getClientOriginalName();
                $file->move(\public_path('course_files/'),$imageName);
                $file = $imageName;
            }else{
                $file = $course->file;

            }

          $course->update([
            'name' => $request->name,
                'term' => $request->term,
                'level' => $request->level,
                'hours' => $request->hours,
                'code' => $request->code,
                'link' => $request->link,
                'file' => $file,

          ]);

          return[
              'data' => $course
          ];



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findorfail($id);

        $staff_id = Course_Staff::where('course_id',$course->id)->first();
        $user_id= $staff_id->staff_id;

        $course->delete();

        return[
            'status' => 'success',
            'data' => 'course deleted'
        ];

  }

  public function user_course(Request $request){

    $data = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'user_id' => 'required|exists:users,id',
    ]);

    Course_User::create($data);

    return[
        'status' => 'course added',
    ];

  }

  public function user_delete_course(Request $request){


    $course = Course_User::where('user_id',$request->user_id)->where('course_id', $request->course_id)->first();

    $course->delete();
    return[
        'status' => 'course deleted',
    ];

  }
}


//  // return $request->all();
//  $data = $request->except('file');

//  if($request->hasFile('file')){
//      $file = $request->file('file');
//      $imageName = time().'_'. $file->getClientOriginalName();
//      $file->move(\public_path('course_files/'),$imageName);
//      $data['file'] = $imageName;
//  }

// $course = Course::create([
//  'name' => $data['name'],
//  'term' => $data['term'],
//  'hours' => $data['hours'],
//  'code' => $data['code'],
//  'link' => $data['link'],
//  'file' => $data['file'],
//  'level' => $data['level'],
//  ]);

// $course_staff = Course_Staff::create([
//  'course_id' => $course->id,
//  'staff_id' => Auth::guard('sanctum')->user()->id,
// ]);

// return[
//  'data' => $course
// ];
