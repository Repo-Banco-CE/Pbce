<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use Session;

class CuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            
        
        $cuentas= Cuenta::all();

        return view('admin.cuentas.index')->with('cuentas',$cuentas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $cuenta= new Cuenta();
/*
        Entidad: XXXX 
        Número de oficina: XXXX 
        Dígitos de control (DC): XX
        Número de cuenta: XXXX-XXXX-XX
*/
        
        $user_id= $request->user_id;

        /**
         *  Verificación de cuentas, solo se crea si la cuenta no existe en la BD 
         */
        
        do {
            
            $parte1=rand(1000, 9999);
            $parte2=rand(1000, 9999);
            $parte3=rand(10, 99);

            $numero_cuenta='2283-5023-75-'.$parte1.'-'.$parte2.'-'.$parte3;

        } while (count(Cuenta::where('numero',$numero_cuenta)->first()) > 0);

        $cuenta->numero=$numero_cuenta;
        $cuenta->tipo='#';
        $cuenta->saldo_cuenta=1000000;
        $cuenta->limite=100000;
        $cuenta->saldo=100000;
        $cuenta->saldo=100000;
        $cuenta->cupo_disponible=100000;
        $cuenta->fecha_corte=10;

        $cuenta->save();

//        printf('Numero de Cuenta <br>'.$cuenta->numero);
     
        $query=Cuenta::where('numero',$numero_cuenta)->first();

        $parametros= ['user_id' => $user_id , 'cuenta_id' => $query->id];
/*
        printf('<br>Los id son<br> ');
        printf($parametros['user_id']);
        printf($parametros['cuenta_id']);
*/
        return view('admin.cuentas_usuarios.create_juridico')->with('id',$parametros);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
        $cuenta= Cuenta::find($id);
        return view('admin.cuentas.show')->with('cuenta',$cuenta);

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
