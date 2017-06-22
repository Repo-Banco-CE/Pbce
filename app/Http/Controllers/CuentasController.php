<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use Session;
use App\User;
use App\Movimientos;
use App\Cuenta_Movimiento;
use Illuminate\Support\Facades\Auth;

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
        
        if (Auth::user()->id == $id) {
        
            $cuenta= Cuenta::find($id);
            return view('admin.cuentas.show')->with('cuenta',$cuenta);

        }else{

            flash('No posee permisos para realizar esta operación.' ,'warning' );
            $cuenta= Cuenta::find(Auth::user()->id);
            return view('admin.cuentas.show')->with('cuenta',$cuenta);

        }

        

       
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

     public function pagartarjeta(Request $request){
     
    if ($request->numero_cuenta == ' ' || $request->numero_tarjeta == ' ') {
     //   printf('Debe llenar todos ls campos del formulario');
        flash('Debe llenar todos los campos del formulario','danger');
        $cuentas= Cuenta::all();

        return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);
       
    }else{

        $numero_cuenta=$request->numero_cuenta;
        $cuenta= Cuenta::where('numero',$numero_cuenta)->first();

    //    printf('Saldo: '.$cuenta->saldo_cuenta);
    //    printf('<br>Pago: '.$request->monto);
        
        if ($request->monto > $cuenta->saldo_cuenta) {
           // printf('Su saldo es insuficiente, por favor verifique e intente nuevamente');
            flash('Su saldo es insuficiente, por favor verifique e intente nuevamente','danger');

            $cuentas= Cuenta::all();

            return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);

        }else{
          //  printf('<br>Procesando transaccion');

            if ($cuenta->saldo == $cuenta->limite) {
            //    printf('<br>No se realizó la operacion debido a que su tarjeta no posee deuda');
                flash('No se realizó la operacion debido a que su tarjeta no posee deuda','danger');
                $cuentas= Cuenta::all();

                return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);

            }else{
                    $saldo_limite=$request->monto + $cuenta->saldo;
                if ($saldo_limite > $cuenta->limite ) {
                    # code...
                    flash('No se realizó la operacion debido a que el pago excede el límite de la tarjeta ','danger');
                    $cuentas= Cuenta::all();

                    return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);
                }else{

                    if (($cuenta->saldo - $request->monto) < 0) {
                        flash('No puede realizar un pago mayor a la deuda pendiente ','danger');
                        $cuentas= Cuenta::all();

                        return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);
                    }else{
                        $cuenta->saldo_cuenta= $cuenta->saldo_cuenta-$request->monto;
                        $cuenta->saldo= $cuenta->saldo-$request->monto;
                        $cuenta->cupo_disponible= $cuenta->cupo_disponible+$request->monto;
                        $cuenta->save();

                        flash('Se ha realizado el pago exitosamente','success');
                        $cuentas= Cuenta::all();

                        return view('admin.cuentas.index')->with('cuentas',$cuentas);
                    }
                }

            }
            
        }

    }
    

    }

    public function afiliar($id){

        if (Auth::user()->id == $id) {
        
            $user= User::find($id);
            $user->afiliacion_comercial=1;
            $user->save();

            flash('Su solicitud ha sido procesada exitosamente.' ,'success' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.index')->with('cuentas',$cuentas);

        }else{

            flash('No posee permisos para realizar esta operación.' ,'warning' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.index')->with('cuentas',$cuentas);

        }

       
    }

    public function retirarse($id){

        if (Auth::user()->id == $id) {
        
            $user= User::find($id);
            $user->afiliacion_comercial=0;
            $user->save();

            flash('Su solicitud ha sido procesada exitosamente.' ,'success' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.index')->with('cuentas',$cuentas);

        }else{

            flash('No posee permisos para realizar esta operación.' ,'warning' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.index')->with('cuentas',$cuentas);

        }
   
    }

    public function transferencia(Request $request){

        $cuenta_origen=$request->cuenta_origen;
        $cuenta_destino=$request->cuenta_destino;
        $monto=$request->monto;
        $tipo=$request->tipo;
        $descripcion="Transferencia";
        $origen="-";
        $destino="+";
        
        if ($tipo == "local") {
        //    printf('transferencia en el mismo banco <br>');
            
            $movimiento_origen= Cuenta::where("numero",$cuenta_origen)->first();
            $movimiento_destino= Cuenta::where("numero",$cuenta_destino)->first();

            if (empty($movimiento_destino)) {
                # code...
                flash('Los datos de la cuenta destino no son válidos.' ,'warning' );
                $cuentas= Cuenta::all();
                return view('admin.cuentas.transferencia')->with('cuentas',$cuentas);
            }


            if ($this->validar_saldo($movimiento_origen->numero,$monto)) {
              
              //  printf('hay plata');

                /**
                 * Actualización de datos en el emisor y creacion de movimientos del emisor
                 */
                
                $movimiento_origen->saldo_cuenta= $movimiento_origen->saldo_cuenta - $monto;
                $movimiento_origen->save();

                $id_mov= $this->agregar_movimiento($origen,$monto,$movimiento_origen->saldo_cuenta,$descripcion);

                $this->agregar_cuenta_movimiento($movimiento_origen->id, $id_mov);

                /**
                 * Actualización de datos en el receptor y creacion de movimientos del emisor
                 */
                
                $movimiento_destino->saldo_cuenta= $movimiento_destino->saldo_cuenta + $monto;
                $movimiento_destino->save();

                $id_mov2= $this->agregar_movimiento($destino,$monto,$movimiento_destino->saldo_cuenta,$descripcion);

                $this->agregar_cuenta_movimiento($movimiento_destino->id, $id_mov2);

                flash('Operación realizada exitosamente' ,'success' );
                $cuentas= Cuenta::all();
                return view('admin.cuentas.index')->with('cuentas',$cuentas);

            } else {
                //printf('no hay plata')
                flash('No posee saldo suficiente para realizar esta operación' ,'warning' );
                $cuentas= Cuenta::all();
                return view('admin.cuentas.transferencia')->with('cuentas',$cuentas);
              
            }
            


        }else{
            printf('transferencia en un banco externo');
        }

    }

    public function agregar_movimiento($ruta, $monto, $saldo,$descripcion){

        $mov= new Movimientos();
        $mov->monto= $monto;
        $mov->descripcion=$descripcion;
        $mov->saldo=$saldo;
        $mov->dc=$ruta;
        $mov->save();

        return $mov->id;

    }

    public function agregar_cuenta_movimiento($id_cuenta,$id_movimiento){

        $cuentas_movimiento= new Cuenta_Movimiento();
        $cuentas_movimiento->movimiento_id=$id_movimiento;
        $cuentas_movimiento->cuenta_id=$id_cuenta;
        $cuentas_movimiento->save();

    }

    public function validar_saldo($cuenta, $monto){

        $data_cuenta= Cuenta::where("numero",$cuenta)->first();

        if ($data_cuenta->saldo_cuenta > $monto) {
            
            return true;
        } else {
            return false;
        }
        

    }


}
