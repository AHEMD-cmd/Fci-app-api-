<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{

    public function __construct()
    {

            $this->middleware('staff_check')->except('index', 'show');

    }




    public function index()
    {
        return Department::all();
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:100',
            'head_of_department' => 'required|string|max:255'
        ]);

        $department = Department::create($data);

        return[
            'data' => $department
        ];
    }




    public function show($id)
    {
        $department = Department::findorfail($id);
        return $department;
    }




    public function update(Request $request, $id)
    {
        $department = Department::findorfail($id);

        $data = $request->validate([
          'name' => 'nullable|string|max:100',
          'code' => 'nullable|string|max:100',
          'head_of_department' => 'nullable|string|max:255'
      ]);

      $department->update($data);

      return[
          'data' => $department
      ];
    }




    public function destroy($id)
    {
        $department = Department::findorfail($id);
        $department->delete();

        return[
            'status' => 'success',
            'data' => 'department deleted'
        ];
    }
}
