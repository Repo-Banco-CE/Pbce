<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juridica extends Model
{
    //

	protected $table = 'juridicas';
    protected $fillable=['user_id','rif'];

     public function user (){

		 return $this->belongsTo('App\User');
    }
}
