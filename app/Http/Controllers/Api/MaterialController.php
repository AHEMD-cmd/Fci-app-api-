<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\StaffType;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct(){

        $this->middleware('staff_check')->except('index', 'show');
    }


    public function index()
    {
        return
        [
          'data' => Material::all()
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
            'name' => 'required|string|max:100',
            'term' => 'required|string|max:100',
            'level' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
        ]);

        $department = Material::create($data);

        return[
            'data' => $department
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
        $department = Material::findorfail($id);
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
        $department = Material::findorfail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'term' => 'required|string|max:100',
            'level' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',

        ]);

      $department->update($data);

      return[
          'data' => $department
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
        $department = Material::findorfail($id);
        $department->delete();

        return[
            'status' => 'success',
            'data' => 'department deleted'
        ];
    }
}
