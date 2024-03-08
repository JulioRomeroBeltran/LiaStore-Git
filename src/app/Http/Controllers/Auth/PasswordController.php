<?php

// app/Http/Controllers/Auth/PasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    public function change(Request $request): RedirectResponse
    {
        try {
            Log::debug('Request data:', $request->all());
    
            // Validate the request data
            $request->validate([
                'new_password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'string', 'min:8', 'same:new_password'],
                'id' => ['required', 'exists:users,id'],
                'token' => ['required'],
            ]);
    
            // Find the user by ID
            $user = User::find($request->input('id'));
    
            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('mensaje', 'Usuario no encontrado.');
            }
    
            // Check if the provided token matches the user's reset token
            if ($user->password_reset_token !== $request->input('token')) {
                return redirect()->back()->with('mensaje', 'Token de restablecimiento de contraseña no válido.');
            }
    
            // Update the user's password
            $user->update([
                'password' => Hash::make($request->input('new_password')),
                'password_reset_token' => null, // Optionally, clear the reset token after successful reset
            ]);
    
            Session::flash('status', 'password-updated');
            Session::flash('delay', 5); // Set the delay in seconds

            return redirect()->route('login');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors if needed
            Log::debug('Validation errors:', $e->errors());
    
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors());
        }
    }
}
