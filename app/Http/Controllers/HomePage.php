<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePage extends Controller
{   
    //MIDDLEARE PARA AUTENTICACAO
   /* public function __construct(){
        $this->middleware('auth');
    }*/


    /**
     * MOSTRA A PAGINA INICIAL DO USUARIO LOGADO
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        //$user = $request->user();
        //$user = auth()->user();
        //$user = Auth::user();

        //return view('home', ['user' => $user]);
        return view('home');
    
    }
}
