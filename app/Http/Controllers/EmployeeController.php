<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Excel;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Models\Department;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $employees = Employee::join('departments','department_id','departments.id')->get();
        return view('home', [
            'employees' => $employees
        ]);
    }

    public function employeesImport(Request $request) {
        $v = Validator::make($request->all(), [
            'fa_upload_file' => 'required',
        ],[
          'fa_upload_file.required' => 'Select a file to upload',
        ]);
        if ($v->fails()) {
          $errors = $v->errors();
          $data['status'] = 0;
          $data['message'] = $errors->first();
          return response()->json($data,200);
        }
        try {
          $input = $request->all();
          $input = array_unique($input);
          if(count($input)<7){
            $data['status'] = 0;
            $data['message'] = "Some column number missing";
            return response()->json($data,200);
          }
          Excel::import(new EmployeeImport($input), $request->file('fa_upload_file'));
          
          $data['status'] = 1;
          $data['message'] = "Done";
          return response()->json($data,200);

        } catch (\Exception $e) {
          $data['status'] = 0;
          $data['message'] = "Invalid Format or insertion failed";
          return response()->json($data,200);
        }
      }

      public function insertValues()
    {
        $depts = new Department();
        $depts->department_name  = 'Unknown';
        $depts->department_code  = 'Nil';
        $depts->save();

        $depts = new Department();
        $depts->department_name  = 'Human Resource';
        $depts->department_code  = 'HR';
        $depts->save();

        $depts = new Department();
        $depts->department_name  = 'Finance';
        $depts->department_code  = 'FIN';
        $depts->save();

        $depts = new Department();
        $depts->department_name  = 'Development';
        $depts->department_code  = 'SE';
        $depts->save();


        echo "Added successfully";
    }
    
}
