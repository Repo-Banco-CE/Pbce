<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cuenta;
use App\Natural;
use App\Juridica;
use Hash;

class OperacionesController extends Controller
{
    

   public function pagocontarjeta(Request $request){

    if ($request->has('numero_tarjeta') && $request->has('Titular') &&  $request->has('Titular_CI') &&  $request->has('FechaDeVencimiento') &&  $request->has('NumeroPedido')&&  $request->has('rif_comercio')&& $request->has('token') &&  $request->has('monto')) {
        
        $cuenta_origen= Cuenta::where('numero_tarjeta',$request->numero_tarjeta)->first();
//        $cedula = Natural::where('Titular_CI',$request->cedula)->first();
        $data_user= User::where('remember_token',$request->token)->first();
        $cuenta_destino= Cuenta::where('id',$data_user->id)->first();

        printf($cuenta_origen);
        printf('<br><br>'.$data_user.'<br><br>');
        printf('<br><br>'.$cuenta_destino.'<br><br>');

        if ($data_user->afiliacion_comercial == 0 ) {
            
            $respuesta=  ["mensaje" => "Actualmente no se encuentra afiliado a este servicio.", "status" => "400" ];
            return response()->json($respuesta,400);

        }else{

    
            if ($cuenta_origen->cupo_disponible < $request->monto) {
                
                $respuesta=  ["mensaje" => "Credito insuficiente", "status" => "100" ];
                return response()->json($respuesta,400);       

            }else{

                $cuenta_origen->cupo_disponible= $cuenta_origen->cupo_disponible - $request->monto;
                $cuenta_origen->saldo= $cuenta_origen->saldo - $request->monto;
                $cuenta_origen->save();

                $cuenta_destino->saldo_cuenta= $cuenta_destino->saldo_cuenta + $request->monto;
                $cuenta_destino->save();

                $respuesta=  ["mensaje" => "Transaccion Aprobada", "status" => "200" ];
                return response()->json($respuesta,200);
            }
    
            
            }


    }else{

        $respuesta= [ "mensaje" => "Datos inavlidos", "status" => "400"];
        return response()->json($respuesta,400);

    }

   }


   public function login( Request $request){

    $email = $request->email;
    $password = $request->password;

    $query= User::where('email',$request->email)->first();
    

    if (count($query) > 0) {

       
        if (Hash::check($password, $query->password)){

            return response()->json(['token' => $query->remember_token], 200);
        
        }else{

            return response()->json(['status' => '401', 'mensaje' => 'Datos invalidos'], 401);
        }
    
    }else{

            return response()->json(['status' => '401', 'mensaje' => 'Datos invalidos'], 401);
    }

   }


}
