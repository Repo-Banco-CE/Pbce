<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/prueba1';

  //  protected $loginPath = '/prueba';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

   public function Login(){

    
    return view('admin.auth.login');
   }

   public function postLogin(Request $request){

    $usuario= User::where('email',$request->email)->first();
/*
    echo($request->tipo_usuario);
    echo($usuario->tipo);
*/    
    if ($usuario == null) {
       if ($request->tipo_usuario == 'natural') {
          flash('Este usuario no se encuentra registrado.', 'danger');
          return view('admin.auth.login');
        }else{
          flash('Este usuario no se encuentra registrado.', 'danger');
          return view('admin.auth.login-juridico');
        }
    }

    if ($request->tipo_usuario == $usuario->tipo) {
      
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
              return redirect()->intended('/admin/users');
              
        }else{
            flash('El correo o la contraseña no coinciden.', 'danger');
            return view('admin.auth.login');
        }

    }else{
        
        if ($request->tipo_usuario == 'natural') {
          flash('Este usuario no se encuentra registrado.', 'danger');
          return view('admin.auth.login');
        }else{
          flash('Este usuario no se encuentra registrado.', 'danger');
          return view('admin.auth.login-juridico');
        }
      
    }

  
    }

   public function logout(){
    Auth::logout();
    return redirect('/');
   }

}




  
