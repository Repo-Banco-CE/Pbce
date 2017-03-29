<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta_Movimiento extends Model
{
    //
    
	protected $table='cuenta_movimiento';
	protected $fillable=['cuenta_id','movimiento_id'];

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }

    public function movimiento()
    {
        return $this->belongsTo('App\Movimientos');
    }
}
