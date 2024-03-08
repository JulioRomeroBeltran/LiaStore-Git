<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/inicio';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    

    // Optionally, you can override other methods if needed

    // protected function authenticated($request, $user)
    // {
    //     Log::info('User authenticated. Redirecting to /inicio.');
    //     return redirect('/inicio');
    // }
}
