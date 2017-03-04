<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

   //  dd($request->all());
   // dd($request->email);
   // printf($request->clave);


    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
              return redirect()->intended('/admin/users');
              
        }else{
            flash('El correo o la contraseña no coinciden.', 'danger');
            return view('admin.auth.login');
        }
     

   }

   public function logout(){
    Auth::logout();
    return redirect('/');
   }

}




  
