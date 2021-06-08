<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function owner()
    {
        return $this->belongsTo($this->getOwnerClass(), 'owner_id');
    }

    private function getOwnerClass()
    {
        switch($this->type) {
            case 'family':
                return \App\Family::class;
            case 'studant':
                return \App\Studant::class;
        }
    }
}
