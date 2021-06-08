<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public static $rules = [
        'bio' => 'max:500',
        'know_from' => 'max:255',
        'hiring_date' => 'required|date',
        'salary_type' => 'required|in:default,custom',
        'salary' => 'required|numeric',
        'bank_name' => 'required|min:3|max:50',
        'bank_office' => 'required|max:10',
        'bank_account' => 'required|max:10',
        'bank_city' => 'required|min:4|max:50',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
