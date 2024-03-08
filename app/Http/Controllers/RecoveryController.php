<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PasswordRecoveryEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;


class RecoveryController extends Controller
{
    public function showEmailInputForm()
    {
        return view('auth.reset-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Password::createToken($user);

            $user->update(['password_reset_token' => $token]);

            Mail::to($user->email)->send(new PasswordRecoveryEmail($token));

            return redirect()->route('password.sent');
        } else {
            return redirect()->route('password.request')->withErrors(['email' => 'Correo no encontrado']);
        }
    }

    public function showResetPasswordConfirmView(Request $request, $token)
    {
        $user = User::where('password_reset_token', $token)->first();
    
        if (!$user) {
            return redirect()->route('password.reset')->withErrors(['mensaje' => 'Algo salió mal.']);
        }
    
        return view('reset-password-confirm', ['user' => $user, 'token' => $token]);
    }


    public function showEmailSentView()
    {
        return view('email_sent');
    }
}
