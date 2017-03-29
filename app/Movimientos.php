<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    public function cuentas_movimientos()
    {
        return $this->hasMany('App\Cuenta_Movimiento');
    }
}
