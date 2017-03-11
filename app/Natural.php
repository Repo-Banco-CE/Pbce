<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Natural extends Model
{
    //
     protected $table = 'naturales';
     protected $fillable=['cedula','user_id'];

     public function user (){
        return $this->belongsTo('App\User');
   
    }
}
