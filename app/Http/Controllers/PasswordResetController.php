<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{   
    // mostra o formulario para requisitar a mensagem de recuperacao de senha
    public function request(){
        return view('auth.passwords.email');
    }

    // Envia a mensagem de email para o endereco do usuario
    public function email(Request $request){

        $request->validate([
            'email' => ['required', 'email']
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                            ? back()->with(['status' => _($status)])
                            : back()->withErrors(['email' => __($status)]);
    }

    // mostra o formulario de alteracao da senha 
    public function reset(){
        return view('auth.passwords.reset');
    }

    // realiza a alteracao da senha no banco de dados
    public function update(Request $request){

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

       $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user, $password){
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return  $status === Password::PASSWORD_RESET
                             ? back()->with(['status' => _($status)])
                             : back()->withErrors(['email' => __($status)]);
    }
}
