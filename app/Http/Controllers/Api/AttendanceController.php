<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\attendanceResource;
use App\Models\perm_attendance;
use App\Models\Temp_attendance;
use Illuminate\Database\Eloquent\Collection;

class AttendanceController extends Controller
{

    public function __construct()
    {

            $this->middleware('staff_check')->except('scan_qr_code');

    }

    public function attendance_per_code(Request $request)
    {

        $request->validate([
            'code' => "required|exists:perm_attendances,code",

        ]);


        $atte =  perm_attendance::with('user')->where('code', $request->code)->get();

        return [
            'users' => attendanceResource::collection($atte)
        ];

    }//end

    public function generate_qr_code(Request $request)
    {
        $randam_code = Str::random(9);

        $data = $request->validate([
            'x' => "required",
            'y' => "required",
            'course_id' => "required|exists:courses,id",
            'section_num' => "integer|nullable",
            'lecture_num' => "integer|nullable"

        ]);
        $data['randam_code'] = $randam_code;

        $t_atte =  Temp_attendance::create($data);

        return [
            'code' => $randam_code
        ];
    }



    public function scan_qr_code(Request $request)
    {

        $randam_code = Temp_attendance::where('randam_code',$request->code)->first();



        if($randam_code && sqrt(pow($randam_code->x - $request->x,2) + pow($randam_code->y - $request->y,2)) <= 100){
        // if($randam_code && pow($randam_code->x - $request->x,2)  < 1000000000){

            if($randam_code->lecture_num){

                perm_attendance::create([
                    "user_id" => $request->user_id,
                    'course_id' => $randam_code->course_id,
                    'lecture_num' => $randam_code->lecture_num,

                ]);
            }else{
                perm_attendance::create([
                    "user_id" => $request->user_id,
                    'course_id' => $randam_code->course_id,
                    'section_num' => $randam_code->section_num,

                ]);
            }
            return[
                'status' => 'code scaned'
            ];

        }
    }


    public function finish_qr_code(Request $request)
    {
        $randam_code = Temp_attendance::where('randam_code',$request->code)->first();
        $randam_code->delete();

        return [
            'status' => 'QR code deleted'
        ];

    }




}
