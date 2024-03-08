<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\PhpMailerService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * The PhpMailer service instance.
     *
     * @var \App\Services\PhpMailerService
     */
    protected $phpMailerService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\PhpMailerService  $phpMailerService
     * @return void
     */
    public function __construct(PhpMailerService $phpMailerService)
    {
        $this->phpMailerService = $phpMailerService;
    }

    /**
     * Send the password reset email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        // Check if the email was not found in the database
        if ($response === Password::INVALID_USER) {
            // Throw a ValidationException with a custom error message
            throw ValidationException::withMessages([
                'email' => ['Tu dirección de correo electrónico no se encuentra en nuestra base de datos.'],
            ]);
        }

        // Customize the reset link as needed
        $resetLink = url("/reset-password-confirm/{$request->route('token')}");

        // Send the reset email using PhpMailerService
        $this->phpMailerService->sendMail($request->email, 'Password Reset', view('emails.reset_password', ['resetLink' => $resetLink])->render());

        // Redirect to the PasswProceso Blade view
        return view('PasswProceso');
    }
}
