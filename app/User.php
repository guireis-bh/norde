<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        // 'salute' => 'in:Sr.,Sra.,Dr.,Dra.',
        'name' => 'required|min:3|max:255',
        'surname' => 'required|min:3|max:255',
        'birthday' => 'required|date',
        'rg' => 'required|regex:/^\d{2}\.\d{3}\.\d{3}\-[\dx]$/u|unique:users',
        'cpf' => 'required|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/u|unique:users',
        'email' => 'required|email|unique:users',
        'email2' => 'email',
        'cellphone' => 'required|regex:/^\(\d{2}\) \d{4,5}\-\d{4}$/u|unique:users',
        'role' => 'required|in:superuser,admin,supervisor,teacher,relative,studant',
    ];

    public function username()
    {
        return 'email';
    }

    public function findForPassport($username) {
        $user = self::where($this->username(), $username)->firstOrFail();
        if(!$user->hasRole('superuser')) {
            $user->configs()
                ->where('key', 'user_login')
                ->where('value', 1)
                ->firstOrFail();
        }
        return $user;
    }

    public function status()
    {
        return $this->belongsTo(\App\Status::class)->withDefault([
            'status_id' => 1
        ]);
    }

    public function address()
    {
        return $this->belongsTo(\App\Address::class);
    }

    public function configs()
    {
        return $this->hasMany(\App\Config::class);
    }

    public function config($key)
    {
        $config = \App\Config::where('user_id', $this->id)
        ->where('key', $key)
        ->firstOrfail();

        return $config->value;
    }

    public function subjects()
    {
        return $this->belongsToMany(\App\Subject::class, 'users_subjects');
    }
}
