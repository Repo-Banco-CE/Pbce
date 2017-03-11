<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta_Usuario extends Model
{
    //
    protected $table = 'cuentas_users';
    protected $fillable=['cuenta_id','user_id'];


    public function user (){
        return $this->belongsTo('App\User');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }
}
