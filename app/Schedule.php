<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public static $rules = [
        'day' => 'required',
        'hour_begin' => 'required',
        'hour_end' => 'required',
    ];
}
