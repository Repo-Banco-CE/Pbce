<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cuenta;
use App\Natural;
use App\Juridica;
use App\Movimientos;
use App\Cuenta_Movimiento;
use Hash;
use GuzzleHttp\Client;


class OperacionesController extends Controller
{



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

/****************************************************************
                        Pago con Tarjeta
****************************************************************/
  

   public function pagocontarjeta(Request $request){

     if ($request->has('NumeroDeTarjeta') && $request->has('Titular') && $request->has('Titular_CI') && $request->has('FechaDeVencimiento') && $request->has('NumeroPedido') && $request->has('rif_comercio') && $request->has('token') && $request->has('Monto')) {

           $numero_tarjeta = $request->get('NumeroDeTarjeta');
           $banco_id = substr($numero_tarjeta, 4, 2);
           //print_r('banco id '.$banco_id);


           if ($banco_id == '03') // identificacion del banco
           {
               $cuenta_origen = Cuenta::where('numero_tarjeta', $request->NumeroDeTarjeta)->first();
               $titular = $request->get('Titular');
               $ci = $request->get('Titular_CI');
               $vencimiento = $request->get('FechaDeVencimiento');
               $rif = $request->get('rif_comercio');


               $consultarif=Juridica::where('rif', $rif)->first();
               if(empty($consultarif)){

                   $respuesta = ["mensaje" => "Comercio no existe", "error" => "400"];
                   return response()->json($respuesta, 400);

               }

               if(empty($consultarif)){

                   $respuesta = ["mensaje" => "Comercio no existe", "error" => "400"];
                   return response()->json($respuesta, 400);

               }

               $datos_cuenta = Cuenta::where('numero_tarjeta', $request->NumeroDeTarjeta)->first();

               if (!empty($datos_cuenta)) {

                   if ($datos_cuenta->fecha_vencimiento == $vencimiento) {
                       //$cedula = Natural::where('cedula', $ci)->where('id', $datos_cuenta->id)->first();
                       $cedula = Natural::where('cedula', $ci)->first();

                       if (!empty($cedula)) {

                           $nombre = User::where('nombre', $titular)->where('id', $datos_cuenta->id)->first();

                           if (empty($nombre)) {

                               $respuesta = ["mensaje" => "Datos invalidos", "error" => "400"];
                               return response()->json($respuesta, 400);
                           }

                       } else {

                           $respuesta = ["mensaje" => "Datos invalidos cedula", "error" => "400"];
                           return response()->json($respuesta, 400);
                       }
                   } else {

                       $respuesta = ["mensaje" => "Tarjeta vencida ", "error" => "400"];
                       return response()->json($respuesta, 400);
                   }

               } else {
                   $respuesta = ["mensaje" => "Tarjeta invalida", "error" => "400"];
                   return response()->json($respuesta, 400);

               }


              $data_user = User::where('remember_token', $request->token)->first();
               $cuenta_destino = Cuenta::where('id', $data_user->id)->first();
               // $cuenta_destino= $numero_cuenta_destino;


               if ($data_user->afiliacion_comercial == 0) {

                   $respuesta = ["mensaje" => "Actualmente no se encuentra afiliado a este servicio.", "error" => "400"];
                   return response()->json($respuesta, 400);

               } else {


                   if ($cuenta_origen->cupo_disponible < $request->Monto) {

                       $respuesta = ["mensaje" => "Credito insuficiente", "error" => "100"];
                       return response()->json($respuesta, 400);

                   } else {
                       $descripcion='Pago con tarjeta';
                       $origen="-";
                       $cuenta_origen->cupo_disponible = $cuenta_origen->cupo_disponible - $request->Monto;
                       $cuenta_origen->saldo = $cuenta_origen->saldo - $request->Monto;
                       $cuenta_origen->save();
                       $id_mov= $this->agregar_movimiento($origen,$request->Monto,$cuenta_origen->saldo_cuenta,$descripcion);
                       $this->agregar_cuenta_movimiento($cuenta_origen->id, $id_mov);


                       $destino="+";
                       $cuenta_destino->saldo_cuenta = $cuenta_destino->saldo_cuenta + $request->Monto;
                       $cuenta_destino->save();
                       $id_mov2= $this->agregar_movimiento($destino,$request->Monto,$cuenta_destino->saldo_cuenta,$descripcion);
                      $this->agregar_cuenta_movimiento($cuenta_destino->id, $id_mov2);




                       $respuesta = ["mensaje" => "Transaccion Aprobada", "data" => "200"];
                       return response()->json($respuesta, 200);
                   }

               }

           }else{ // otro banco
           



               if($banco_id != '01' and $banco_id != '02' ){

                   //print_r('ninguno ');
                   $respuesta = ["mensaje" => "Datos invalidos banco no existe", "error" => "400"];
                  return response()->json($respuesta, 400);

               }


               if ($banco_id == '01') // Banco NJG
               {
                   //print_r('juan ');
                  $client = new Client([
                                        'timeout'  => 2.0
                                        ]);

                  $Data = [
                  "NumeroDeTarjeta" => $request->NumeroDeTarjeta,
                  "Titular" => $request->Titular,
                  "Titular_CI" => $request->Titular_CI,
                  "FechaDeVencimiento" => $request->FechaDeVencimiento,
                  "NumeroPedido" => $request->NumeroPedido,
                  "rif_comercio" => $request->rif_comercio,
                  "rif_comercio" => $request->rif_comercio,
                  "Monto" => $request->Monto,
                  "Monto" => $request->Monto,
                  "token" => $request->token
                  ];

                   $response = $client->post('https://njg.herokuapp.com/users/pagar', ['form_params' => $Data]);
                   return json_decode($response->getBody()->getContents(),200);


                

               }

              if ($banco_id == '02') // Banco Unibank
              {
                  //print_r('francisco ');
                   $client = new Client([
                                        'timeout'  => 2.0
                                        ]);

                  $Data = [
                  "NumeroDeTarjeta" => $request->NumeroDeTarjeta,
                  "Titular" => $request->Titular,
                  "Titular_CI" => $request->Titular_CI,
                  "FechaDeVencimiento" => $request->FechaDeVencimiento,
                  "NumeroPedido" => $request->NumeroPedido,
                  "rif_comercio" => $request->rif_comercio,
                  "rif_comercio" => $request->rif_comercio,
                  "Monto" => $request->Monto,
                  "Monto" => $request->Monto,
                  "token" => $request->token
                  ];

                   $response = $client->post('https://apiunibank.herokuapp.com/usuarios/tarjetas-credito/pago', ['form_params' => $Data]);
                   return json_decode($response->getBody()->getContents(),200);
               }


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



