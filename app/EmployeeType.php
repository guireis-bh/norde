<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    protected $table = 'employee_types';
    
    public static $rules = [
        'name' => 'required|max:60',
        'role' => 'required|regex:/^[a-z0-9_]+$/u|max:60',
        'default_salary' => 'required|numeric',
    ];

    public function employees()
    {
        return $this->hasMany(\App\Employee::class);
    }
}
