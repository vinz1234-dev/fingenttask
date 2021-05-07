<?php

namespace App\Imports;

//use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employee;
use App\Models\Department;
use Carbon\Carbon;
use Excel;
use DB;
use Validator;
use Illuminate\Support\Facades\Hash;
class EmployeeImport implements ToCollection,WithHeadingRow
{

    public function  __construct($input)
    {
        $this->input = $input;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection1)
    {
        $final_result_all = [];
        $final_result_errors = []; 
        
        $emp_code_col = $this->input['emp_code'] -1;
        $emp_name_col = $this->input['emp_name'] -1;
        $dept_col = $this->input['dept'] -1;
        $dob_col = $this->input['dob'] -1;
        $joining_date_col = $this->input['joining_date'] -1;
        $error_count = 0;
        foreach ($collection1->chunk(20) as $collection)
        {
            foreach ($collection as $row)
            {
                $row = array_values($row->toArray());
                $final_res = [];
                $errors = [];
                $errors_array = [];
                if(count($row) < 5){
                    $data['status'] = 0;
                    $data['message'] = "Column count is less than 5";
                    echo json_encode($data);
                    exit; 
                }
                $employee_code = trim($row[$emp_code_col]);
                $employee_name = trim($row[$emp_name_col]);
                $dob = trim($row[$dob_col]);
                if(!$dob){
                    $data['status'] = 0;
                    $data['message'] = "DOB is missing";
                    echo json_encode($data);
                    exit; 
                }
                $department = trim($row[$dept_col]);
                if(!$department){
                    $data['status'] = 0;
                    $data['message'] = "Department is missing";
                    echo json_encode($data);
                    exit; 
                }else{
                    $dept = Department::select('id')->where('department_name', ucwords($department))->orWhere('department_code', strtoupper($department))->get()->first();
                    if ($dept)
                    {
                        $dept_id = $dept->id;
                    }else{
                        $dept_id = 0;
                    }
                }
                $joining_date = trim($row[$joining_date_col]);
                if(!$joining_date){
                    $data['status'] = 0;
                    $data['message'] = "Joining date is missing";
                    echo json_encode($data);
                    exit; 
                }
                {
                    $id = "";
                    $emp_details = new Employee();

                    $emp_details->employee_code = $employee_code;
                    $emp_details->name = $employee_name;
                    $emp_details->dob = $dob;
                    $emp_details->department_id = $dept_id;
                    $emp_details->joining_date = $joining_date;

                    if (count($errors) == 0)
                    {
                      $status = 1;
                    }
                    else
                    {
                        $status = 0;
                    }                  
                    $emp_details->save();
               

                }

            }
        }
        DB::commit();
        $data['status'] = $status;
        $data['message'] = "File Imported";

        echo json_encode($data);
        exit;
    }
}

