<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cuenta_Movimiento;
use App\Movimientos;

class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    //    printf('movimientos index user con id: '.Auth::user()->id.'<br>');

        $cuenta_movimiento= Cuenta_Movimiento::all();
        $user_mov=[];

        foreach ($cuenta_movimiento as $movimiento) {
        
        //        printf($movimiento->id.'<br>');
                if ($movimiento->cuenta_id == Auth::user()->id) {
                     
                    $mov= Movimientos::find($movimiento->movimiento_id);    
                    array_push($user_mov, $mov);

                    }    
        }

   //     dd($user_mov);
        return view('admin.movimientos.index')->with("user_mov",$user_mov);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tarjeta()
    {
        $cuenta_movimiento= Cuenta_Movimiento::all();
        $user_mov=[];

        foreach ($cuenta_movimiento as $movimiento) {
        
        //        printf($movimiento->id.'<br>');
                if ($movimiento->cuenta_id == Auth::user()->id) {
                     
                    $mov= Movimientos::find($movimiento->movimiento_id);    
                    array_push($user_mov, $mov);

                    }    
        }

   //     dd($user_mov);
        return view('admin.movimientos.tarjetas')->with("user_mov",$user_mov);
    }
}
