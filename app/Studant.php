<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studant extends Model
{
    public static $rules = [
        'entry_date' => 'required|date',
        'grade' => 'required|date',
        'calendar_color' => 'required|regex:/#(?:[0-9a-fA-F]{3}){1,2}/u',
        'payment_method' => 'required|in:default,custom',
        'payment_value' => 'required|numeric',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function family()
    {
        return $this->belongsTo(\App\Family::class);
    }

    public function responsible()
    {
        return $this->belongsTo(\App\Relative::class, 'responsible_id');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Employee::class, 'teacher_id');
    }

    public function service()
    {
        return $this->belongsTo(\App\Service::class);
    }
}
