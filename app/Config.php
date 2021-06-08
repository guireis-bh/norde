<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'user_id',
        'key',
        'type',
        'value',
    ];

    public static $rules = [
        'key' => 'required|regex:/^[a-z0-9_]+$/u',
        'type' => 'required|in:boolean,numeric,string',
        'value' => 'required|max:255',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
