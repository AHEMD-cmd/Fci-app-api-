<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(){

        $this->middleware('staff_check')->except('index', 'show');
    }


    public function messages_per_email($email)
    {
        return
        [
          'data' => Message::where('email', $email)->get()
        ];
    }

    public function index()
    {
        return
        [
          'data' => Message::all()
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
        $data = $request->validate([
            'message' => 'required|string|max:100',
            'file' => 'required',
            'father_email' => 'required|string|max:250',
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('messages_files/'),$imageName);
            $data['file'] = $imageName;
        }


        $message = Message::create($data);

        return[
            'data' => $message
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
        $department = Message::find($id);
        
        if(!$department){
             return 'this record does not exist';
        }
        return $department;
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
        $message = Message::find($id);

        if(!$message){
            return 'this record does not exist';
       }

        $data = $request->validate([
            'message' => 'required|string|max:100',
            'file' => 'required',
            'father_email' => 'required|string|max:250',

        ]);

      $message->update($data);

      return[
          'data' => $message
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
        $message = Message::findorfail($id);
        if(!$message){
            return 'this record does not exist';
       }
        $message->delete();

        return[
            'status' => 'success',
            'data' => 'department deleted'
        ];
    }
}
