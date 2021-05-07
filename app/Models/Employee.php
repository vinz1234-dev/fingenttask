<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    	/**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'employees';
    protected $fillable = ['employee_code','name','dob','department_id','joining_date'];
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }
}
