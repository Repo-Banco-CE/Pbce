<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_Usuario extends Model
{
	protected $table="facturas_users";
    protected $fillable=['cuenta_id', 'factura_id'];
}
