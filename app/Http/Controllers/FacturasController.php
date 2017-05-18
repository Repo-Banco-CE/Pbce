<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Juridica;
use App\Cuenta;
use App\Factura;
use App\Factura_Usuario;
use App\Movimientos;
use App\Cuenta_Movimiento;

class FacturasController extends Controller
{

/********************************************************
 *      Mostrar información de Facturas por Cobrar       *
 ********************************************************/

    public function facturas_activas (){

        $facturas= Factura::all();

        return view('admin.facturas.facturas_activas')->with('facturas',$facturas);
    }

    public function facturas_pagadas (){

        $facturas= Factura::all();

        return view('admin.facturas.facturas_pagadas')->with('facturas',$facturas);
    }

    public function facturas_vencidas (){

        $facturas= Factura::all();

        return view('admin.facturas.facturas_vencidas')->with('facturas',$facturas);
    }

/********************************************************
 *      Mostrar información de Facturas por Pagar       *
 ********************************************************/

    public function pagarfacturas_activas (){

        $facturas= Factura::all();

        return view('admin.facturas.Pagar_facturas_activas')->with('facturas',$facturas);
    }

    public function pagarfacturas_pagadas (){

        $facturas= Factura::all();

        return view('admin.facturas.Pagar_facturas_pagadas')->with('facturas',$facturas);
    }

    public function pagarfacturas_vencidas (){

        $facturas= Factura::all();

        return view('admin.facturas.Pagar_facturas_vencidas')->with('facturas',$facturas);
    }



/********************************************************
 *                  Crear Facturas                      *
 ********************************************************/

    public function factura_create(Request $request){

        
         // Verificación de los parámetros enviados en la solicitud
        
        if ($request->has('token') && $request->has('rif_distribuidor') && $request->has('rif_comercio') && $request->has('nombre_comercio') && $request->has('ref_factura') && $request->has('monto') && $request->has('fecha_plazo') && $request->has('fecha_emision') ) {
            
            $distribuidor_jur= Juridica::where('rif',$request->rif_distribuidor)->first();
            $comercio_jur= Juridica::where('rif',$request->rif_comercio)->first();
            
            if (!empty($distribuidor_jur) && !empty($comercio_jur)) {
            
                $distribuidor_user= $distribuidor_jur->user;
                $comercio_user= $comercio_jur->user;

                if (!empty($distribuidor_user) && !empty($comercio_user)) {
                    
                    if ($request->token == $distribuidor_user->remember_token) {
                        
                        $referencia=Factura::where('ref_factura',$request->ref_factura)->first();

                        if (empty($referencia)) {

                            $factura = new Factura();
                            $factura->fecha_emision=$request->fecha_emision;
                            $factura->fecha_vencimiento=$request->fecha_plazo;
                            $factura->monto=$request->monto;
                            $factura->estado="activa";
                            $factura->rif_distribuidor=$request->rif_distribuidor;
                            $factura->rif_comercio=$request->rif_comercio;
                            $factura->nombre_comercio=$request->nombre_comercio;
                            $factura->ref_factura=$request->ref_factura;
                            $factura->save();
                    
                            $query=Factura::where('ref_factura',$factura->ref_factura)->first();

                            if (!empty($query)) {

                                $facturas_users= new Factura_Usuario();
                                $facturas_users->cuenta_id=$distribuidor_user->id;
                                $facturas_users->factura_id=$query->id;         
                                $facturas_users->save();
                            
                                $respuesta= ['data' => '200' , 'mensaje' => 'La Factura fue enviada exitosamente.' ];
                                return response()->json($respuesta,400);

                            }else{

                                $respuesta= ['error' => '400' , 'mensaje' => 'No se pudo crear la factura exitosamente' ];
                                return response()->json($respuesta,400);
                            }   
                            
                            }else{
                                $respuesta= ['error' => '400' , 'mensaje' => 'El numero de referencia ya se encuentra usado' ];
                                return response()->json($respuesta,400);
                            }

                    }else{

                        $respuesta= ['error' => '400' , 'mensaje' => 'El token enviado es invalido' ];
                        return response()->json($respuesta,400);
                    }
                    
                }else{

                    $respuesta= ['error' => '400' , 'mensaje' => 'El usuario asociado al rif no se encuentran registrados en el banco'];
                    return response()->json($respuesta,400);
                }

            }else{

                $respuesta= ['error' => '400' , 'mensaje' => 'El rif del distribuidor o comercio no se encuentran registrados en el banco'];
                return response()->json($respuesta,400);

            }

        }else{

            $respuesta= ['error' => '400' , 'mensaje' => 'Datos invalidos'];

            return response()->json($respuesta,400);
        }

    }

/********************************************************
 *                  Pagar Factura                      *
 ********************************************************/
    public function pagarfactura ($id){


        $factura= Factura::where('id',$id)->first();

        $juridico_distribuidor= Juridica::where('rif',$factura->rif_distribuidor)->first();
        $juridico_comercio= Juridica::where('rif',$factura->rif_comercio)->first();

        $cuenta_distribuidor= Cuenta::where('id',$juridico_distribuidor->user_id)->first();
        $cuenta_comercio= Cuenta::where('id',$juridico_comercio->user_id)->first();
        
        if ($this->transferencia($cuenta_comercio->numero,$cuenta_distribuidor->numero,$factura->monto,"local","Pago a Proveedor")) {

            $factura->estado="pagada";
            $factura->save();

            flash('Operación realizada exitosamente' ,'success' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.index')->with('cuentas',$cuentas);
        
        }else{

            flash('No posee saldo suficiente para realizar esta operación' ,'warning' );
            $cuentas= Cuenta::all();
            return view('admin.cuentas.transferencia')->with('cuentas',$cuentas);   
        }

     //   printf($cuenta_distribuidor."\n");
       // printf($cuenta_comercio);

       // return view('admin.facturas.Pagar_facturas_vencidas')->with('facturas',$facturas);
    }

     public function transferencia($cuenta_origen,$cuenta_destino,$monto,$tipo,$descripcion){

        $origen="-";
        $destino="+";
        
        if ($tipo == "local") {
        //    printf('transferencia en el mismo banco <br>');
            
            $movimiento_origen= Cuenta::where("numero",$cuenta_origen)->first();
            $movimiento_destino= Cuenta::where("numero",$cuenta_destino)->first();

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

         /*       flash('Operación realizada exitosamente' ,'success' );
                $cuentas= Cuenta::all();
              return view('admin.cuentas.index')->with('cuentas',$cuentas);
        */
                return true;

            } else {
                //printf('no hay plata')
            /*    flash('No posee saldo suficiente para realizar esta operación' ,'warning' );
                $cuentas= Cuenta::all();
                return view('admin.cuentas.transferencia')->with('cuentas',$cuentas);
              */
                return false;
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
