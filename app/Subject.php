<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
    ];

    public static $rules = [
        'name' => 'required|unique:subjects|max:80',
    ];

    public function user()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
