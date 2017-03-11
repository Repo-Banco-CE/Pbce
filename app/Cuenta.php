<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    //
    protected $table = 'cuentas';
    protected $fillable=['numero','tipo','saldo_cuenta','limite','saldo','cupo_disponible','fecha_corte'];

    public function cuentas_users()
    {
        return $this->hasMany('App\Cuenta_Usuario');
    }
}
