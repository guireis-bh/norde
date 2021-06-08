<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    public static $rules = [
        
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function family()
    {
        return $this->belongsTo(\App\Family::class);
    }

    public function studants()
    {
        return $this->hasMany(\App\Studant::class, 'responsible_id');
    }
}
