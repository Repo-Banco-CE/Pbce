<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //
    
    protected $table="facturas";
    protected $fillable=['fecha_emision','fecha_vencimiento','monto', 'estado', 'rif_distribuidor', 'rif_comercio', 'nombre_comercio','						 ref_factura'];

    public function facturas_users()
    {
        return $this->hasMany('App\Factura_Usuario');
    }
}
