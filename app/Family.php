<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $appends = [
        'num_members'
    ];
    
    public static $rules = [
        'name' => 'required|unique:families|max:255',
    ];

    public function relatives()
    {
        return $this->hasMany(\App\Relative::class);
    }

    public function studants()
    {
        return $this->hasMany(\App\Studant::class);
    }

    public function members()
    {
        return (object) array_merge((array) $this->relatives, (array) $this->studants);
    }

    public function getNumMembersAttribute()
    {
        return $this->relatives->count() + $this->studants->count();
    }
}
