<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cuenta;
use App\Natural;
use App\Juridica;
use Hash;
use GuzzleHttp\Client;

class OperacionesController extends Controller
{
    

/****************************************************************
                        Pago con Tarjeta
****************************************************************/
  

   public function pagocontarjeta(Request $request){

     if ($request->has('numero_tarjeta') && $request->has('Titular') && $request->has('Titular_CI') && $request->has('FechaDeVencimiento') && $request->has('NumeroPedido') && $request->has('rif_comercio') && $request->has('token') && $request->has('monto')) {

           $numero_tarjeta = $request->get('numero_tarjeta');
           $banco_id = substr($numero_tarjeta, 4, 2);
           print_r('banco id '.$banco_id);


           if ($banco_id == '03') // identificacion del banco
           {
               $cuenta_origen = Cuenta::where('numero_tarjeta', $request->numero_tarjeta)->first();
               $titular = $request->get('Titular');
               $ci = $request->get('Titular_CI');
               $vencimiento = $request->get('FechaDeVencimiento');
               $rif = $request->get('rif_comercio');

               $consultarif=Juridica::where('rif', $rif)->first();

               if(empty($consultarif)){

                   $respuesta = ["mensaje" => "Comercio no existe", "status" => "400"];
                   return response()->json($respuesta, 400);

               }

               $datos_cuenta = Cuenta::where('numero_tarjeta', $request->numero_tarjeta)->first();

               if (!empty($datos_cuenta)) {

                   if ($datos_cuenta->fecha_vencimiento == $vencimiento) {
                       $cedula = Natural::where('cedula', $ci)->where('id', $datos_cuenta->id)->first();

                       if (!empty($cedula)) {

                           $nombre = User::where('nombre', $titular)->where('id', $datos_cuenta->id)->first();

                           if (empty($nombre)) {

                               $respuesta = ["mensaje" => "Datos invalidos", "status" => "400"];
                               return response()->json($respuesta, 400);
                           }

                       } else {

                           $respuesta = ["mensaje" => "Datos invalidos cedula", "status" => "400"];
                           return response()->json($respuesta, 400);
                       }
                   } else {

                       $respuesta = ["mensaje" => "Tarjeta vencida ", "status" => "400"];
                       return response()->json($respuesta, 400);
                   }

               } else {
                   $respuesta = ["mensaje" => "Tarjeta invalida aaa", "status" => "400"];
                   return response()->json($respuesta, 400);

               }


               $data_user = User::where('remember_token', $request->token)->first();
               $cuenta_destino = Cuenta::where('id', $data_user->id)->first();



               if ($data_user->afiliacion_comercial == 0) {

                   $respuesta = ["mensaje" => "Actualmente no se encuentra afiliado a este servicio.", "status" => "400"];
                   return response()->json($respuesta, 400);

               } else {


                   if ($cuenta_origen->cupo_disponible < $request->monto) {

                       $respuesta = ["mensaje" => "Credito insuficiente", "status" => "100"];
                       return response()->json($respuesta, 400);

                   } else {

                       $cuenta_origen->cupo_disponible = $cuenta_origen->cupo_disponible - $request->monto;
                       $cuenta_origen->saldo = $cuenta_origen->saldo - $request->monto;
                       $cuenta_origen->save();

                       $cuenta_destino->saldo_cuenta = $cuenta_destino->saldo_cuenta + $request->monto;
                       $cuenta_destino->save();

                       $respuesta = ["mensaje" => "Transaccion Aprobada", "status" => "200"];
                       return response()->json($respuesta, 200);
                   }

               }

           }else{ // otro banco
           
               $respuesta = ["mensaje" => "Datos invalidos otro banco", "status" => "400"];
               return response()->json($respuesta, 400);

       }

       }

   }



/****************************************************************
                        Login de Usuarios
****************************************************************/


   public function login( Request $request){

    $email = $request->email;
    $password = $request->password;

    $query= User::where('email',$request->email)->first();

        

    if (count($query) > 0) {

        if ($query->afiliacion_comercial == 0) {
            return response()->json(['error' => '403', 'mensaje' => 'Usted no posee afiliacion comercial'], 403);
        }
       
        if (Hash::check($password, $query->password)){

            return response()->json(['data' => '200', 'mensaje' => 'Se ha autenticado exitosamente','token' => $query->remember_token], 200);
        
        }else{

            return response()->json(['error' => '401', 'mensaje' => 'Datos invalidos'], 401);
        }
    
    }else{

            return response()->json(['error' => '401', 'mensaje' => 'Datos invalidos'], 401);
    }

   }


/****************************************************************
                        Consultar otras apis
****************************************************************/

public function consulta_http(){

  $client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://127.0.0.1:8000/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

  $response = $client->request('GET', 'prueba');

  return json_decode($response->getBody()->getContents());

}


}



