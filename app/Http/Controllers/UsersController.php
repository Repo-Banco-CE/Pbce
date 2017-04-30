<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Juridica;
use App\Natural;
use App\Cuenta;
use App\Cuenta_Usuario;
use Laracasts\Flash\Flash;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // dd('Aqui voy a crear un usuario');

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        
        /*****************************
         * Agrega usuario a la tabla *
         *****************************/

        $user= new User();
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->nombre=$request->nombre;
        $user->direccion=$request->direccion;
        $user->telefono=$request->telefono;        
        $user->tipo=$request->tipo_usuario;
        $user->afiliacion_comercial=0;


        do {
            
            $token=str_random(15);

        } while (count(User::where('remember_token',$token)->first()) > 0);


        $user->remember_token= $token;      
        $user->save();

        /******************************
         * Agrega juridico a la tabla *
         ******************************/

        $user2 = User::where('email',$user->email)->first();

        if ($request->tipo_usuario == 'juridico') {
        
        $rif='V-'.$request->rif;
        $id= $user2->id;

        $juridico= new Juridica();
        $juridico->rif=$rif;
        $juridico->user_id=$id;
        $juridico->save();

        }else{

        $cedula=$request->cedula;
        $id= $user2->id;

        $natural= new Natural();
        $natural->cedula=$cedula;
        $natural->user_id=$id;
        $natural->save();

        }
        

       
       
        /****************************
         * Agrega cuenta a la tabla *
         ****************************/

        if ($request->tipo_usuario == 'juridico') {

        $cuenta= new Cuenta();
/*
        Entidad: XXXX 
        Número de oficina: XXXX 
        Dígitos de control (DC): XX
        Número de cuenta: XXXX-XXXX-XX
*/
        
        $user_id= $id;

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
        $cuenta->tipo='Corriente';
        $cuenta->saldo_cuenta=1000000;
        $cuenta->limite=0;
        $cuenta->saldo=0;
        $cuenta->cupo_disponible=0;
        $cuenta->fecha_corte=0;
        $cuenta->numero_tarjeta=0;
        $cuenta->fecha_vencimiento="05-2021";
        
        $cuenta->save();

//        printf('Numero de Cuenta <br>'.$cuenta->numero);
     
        $query=Cuenta::where('numero',$numero_cuenta)->first();

        /**************************************
         * Agrega Cuentas_Usuarios a la tabla *
         **************************************/

        $cuentas= new Cuenta_Usuario();   
        $cuentas->user_id=$id;
        $cuentas->cuenta_id=$query->id;
    
        $cuentas->save();

        flash('Se ha Registrado a "'.$user->nombre.'" exitosamente', 'success');
   //     return view('admin.juridicas.create-juridico')->with('user',$user2);
        return redirect()->route('admin.auth.login-juridico');

        }else{

        $cuenta= new Cuenta();
/*
        Entidad: XXXX 
        Número de oficina: XXXX 
        Dígitos de control (DC): XX
        Número de cuenta: XXXX-XXXX-XX
*/
        
        $user_id= $id;

        /**
         *  Verificación de cuentas, solo se crea si la cuenta no existe en la BD 
         */
        
        do {
            
            $parte1=rand(1000, 9999);
            $parte2=rand(1000, 9999);
            $parte3=rand(10, 99);

            $numero_cuenta='2283-5023-75-'.$parte1.'-'.$parte2.'-'.$parte3;

        } while (count(Cuenta::where('numero',$numero_cuenta)->first()) > 0);

        /**
         * Verificación de tarjetas, solo se crean si no existen en la BD
         */
        
        do {
            $numero_tarjeta='45400323'.$parte1.''.$parte2;

        } while (count(Cuenta::where('numero',$numero_tarjeta)->first()) > 0);

        $cuenta->numero=$numero_cuenta;
        $cuenta->tipo='Corriente';
        $cuenta->saldo_cuenta=500000;
        $cuenta->limite=100000;
        $cuenta->saldo=100000;
        $cuenta->cupo_disponible=100000;
        $cuenta->fecha_corte="2017-7-10";
        $cuenta->numero_tarjeta=$numero_tarjeta;
        $cuenta->fecha_vencimiento="05-2021";

        $cuenta->save();

//        printf('Numero de Cuenta <br>'.$cuenta->numero);
     
        $query=Cuenta::where('numero',$numero_cuenta)->first();

        /**************************************
         * Agrega Cuentas_Usuarios a la tabla *
         **************************************/

        $cuentas= new Cuenta_Usuario();   
        $cuentas->user_id=$id;
        $cuentas->cuenta_id=$query->id;
    
        $cuentas->save();

        flash('Se ha Registrado a "'.$user->nombre.'" exitosamente', 'success');
   //     return view('admin.juridicas.create-juridico')->with('user',$user2);
        return redirect()->route('admin.auth.login');

        }

        
/*
        printf($cuentas.'<br>');
        printf($juridico.'<br>');
        printf($user);
*//*
        flash('Se ha Registrado a "'.$user->nombre.'" exitosamente', 'success');
   //     return view('admin.juridicas.create-juridico')->with('user',$user2);
        return redirect()->route('admin.auth.login');
*/

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
        
        $user=User::find($id);
       // dd($user);
        return view('admin.users.edit')->with('user',$user);
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
       // dd($id);
      //dd($request->all());
        $user=User::find($id);
        $user->fill($request->all());
    /*    $user->name=$request->name;
        $user->email=$request->email;
        $user->type=$request->type;
    */  $user->save();

        flash('El usuario "'.$user->name.'" se ha editado exitosamente', 'success');
        return redirect('admin/users');
        //dd($user);

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
        $user=User::find($id);
        User::destroy($id);

        flash('Se ha eliminado el usuario "'.$user->name.'" exitosamente', 'warning');
        return redirect('admin/users');
    }
}
