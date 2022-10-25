<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutheticationController extends Controller
{
    //MOSTRA O FOMULARIO DE LOGIN
    public function login(){
        return view('auth.login');
    }

    //  REALIZAR O LOGIN
    public function logar(Request $request)
    {   
        //validacao
       $dados = $request->validate([
            'email' => ['required' ,'email'],
            'password'=> ['required']
        ]);
        
        //verificar se os dados passado estao ok
        if(Auth::attempt($dados, $request->filled('remember'))){
            $request->session()->regenerate();

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'O email e/ou senha não são invalidos',
            'password' => 'O email e/ou senha não são invalidos'
        ]);

    }

    // REALIZAR O LOGOUT
    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

    }
}
