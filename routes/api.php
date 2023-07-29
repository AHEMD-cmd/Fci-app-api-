<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DepartmentController;

/*
|--------------------------------------------------------------------------
| API R outes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
https://what-a-site.000webhostapp.com/api/user

Route::apiResource('message', 'Api\MessageController')->middleware('auth:sanctum');
Route::apiResource('messages_per_email/{email}', 'Api\MessageController@messages_per_email')->middleware('auth:sanctum');

Route::apiResource('departments', 'Api\DepartmentController')->middleware('auth:sanctum');
Route::apiResource('users', 'Api\UserController')->except('delete', 'update');
Route::apiResource('staff', 'Api\StaffController');
Route::apiResource('father', 'Api\FatherController');
Route::apiResource('course', 'Api\CourseController')->except('delete', 'update')->middleware('auth:sanctum');

Route::post('/course_delete/{id}', 'Api\CourseController@destroy')->middleware('auth:sanctum');
Route::post('/course_update/{id}', 'Api\CourseController@update')->middleware('auth:sanctum');
Route::apiResource('post', 'Api\PostController')->middleware('auth:sanctum');
Route::apiResource('reply', 'Api\ReplyController')->middleware('auth:sanctum');
Route::apiResource('testimonial', 'Api\TestimonialController')->middleware('auth:sanctum');
Route::apiResource('quiz', 'Api\QuizController')->middleware('auth:sanctum');
Route::apiResource('quistion', 'Api\QuistionController')->middleware('auth:sanctum');
Route::apiResource('answer', 'Api\AnswerController')->middleware('auth:sanctum');
Route::apiResource('all_quiz', 'Api\AllQuizController')->middleware('auth:sanctum');
Route::apiResource('answer_all_quiz', 'Api\AnswerAllQuizController')->middleware('auth:sanctum');

Route::post('generate_code', 'Api\AttendanceController@generate_qr_code')->middleware('auth:sanctum');
Route::post('scan_code', 'Api\AttendanceController@scan_qr_code')->middleware('auth:sanctum');
Route::get('delete_code', 'Api\AttendanceController@finish_qr_code')->middleware('auth:sanctum');
Route::post('users_per_code', 'Api\AttendanceController@attendance_per_code')->middleware('auth:sanctum');


// ->middleware(StaffType::class)


Route::post('add_course', 'Api\CourseController@user_course')->middleware('auth:sanctum');
Route::post('delete_course', 'Api\CourseController@user_delete_course')->middleware('auth:sanctum');


//assignments
Route::get('/lecture_assignments_per_id/{course_id}', 'Api\LectureAssignmentController@lecture_assignments')->middleware('auth:sanctum');
Route::apiResource('lecture_assignment', 'Api\LectureAssignmentController')->except('index', 'update', 'delete')->middleware('auth:sanctum');
Route::post('lecture_assignment/update/{id}', 'Api\LectureAssignmentController@update')->middleware('auth:sanctum');
Route::get('lecture_assignment/delete/{id}', 'Api\LectureAssignmentController@destroy')->middleware('auth:sanctum');
Route::get('/lecture_assignment_answers_per_id/{assignment_id}', 'Api\LectureAssignmentAnswersController@lecture_assignment_answers')->middleware('auth:sanctum');
Route::post('/lecture_assignment_answers_store', 'Api\LectureAssignmentAnswersController@store')->middleware('auth:sanctum');

Route::get('/section_assignments_per_id/{course_id}', 'Api\SectionAssignmentController@section_assignments')->middleware('auth:sanctum');
Route::apiResource('sectin_assignment', 'Api\SectionAssignmentController')->except('index', 'update', 'destroy')->middleware('auth:sanctum');
Route::post('sectin_assignment/update/{id}', 'Api\SectionAssignmentController@update')->middleware('auth:sanctum');
Route::get('sectin_assignment/delete/{id}', 'Api\SectionAssignmentController@destroy')->middleware('auth:sanctum');
Route::get('/section_assignment_answers_per_id/{assignment_id}', 'Api\SectionAssignmentAnswerController@section_assignment_answers')->middleware('auth:sanctum');
Route::post('/section_assignment_answers_store', 'Api\SectionAssignmentAnswerController@store')->middleware('auth:sanctum');

//lectures

Route::get('course_lectures/{id}', 'Api\LecturesController@course_lectures')->middleware('auth:sanctum');
Route::apiResource('lectures', 'Api\LecturesController')->middleware('auth:sanctum');
Route::post('lectures/update/{id}', 'Api\LecturesController@update')->middleware('auth:sanctum');
Route::get('lectures/delete/{id}', 'Api\LecturesController@destroy')->middleware('auth:sanctum');

//sections
Route::get('course_sections/{id}', 'Api\SectionsController@course_sections')->middleware('auth:sanctum');
Route::apiResource('sections', 'Api\SectionsController')->middleware('auth:sanctum');
Route::post('sections/update/{id}', 'Api\SectionsController@update')->middleware('auth:sanctum');
Route::get('sections/delete/{id}', 'Api\SectionsController@destroy')->middleware('auth:sanctum');


//authentication

Route::post('login', 'Api\LoginController@store');
Route::get('logout', 'Api\LoginController@logout')->middleware('auth:sanctum');

Route::post('login/staff', 'Api\StaffLoginController@store');
Route::get('logout/staff', 'Api\StaffLoginController@logout')->middleware('auth:sanctum');

Route::post('login/father', 'Api\FatherLoginController@store');
Route::get('logout/staff', 'Api\FatherLoginController@logout')->middleware('auth:sanctum');
