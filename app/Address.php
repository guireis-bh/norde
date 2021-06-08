<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    public static $rules = [
        // Address
        'street' => 'required|min:3|max:255',
        'number' => 'required|max:20',
        'city' => 'required|max:100',
        'state' => 'required|size:2',
        'country' => 'required|min:4|max:50',
        'postalcode' => 'required|regex:/^\d{5}\-\d{3}$/',
    ];

    public function user()
    {
        return $this->hasOne(\App\User::class);
    }
}
