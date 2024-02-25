<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function logout()
    {
        Auth::logout();
    
        // Bersihkan sesi kunjungan
        session()->flush();
    
        return redirect('/login');
    }
    

    // Override method redirectTo to customize redirection based on the user's level
    protected function redirectTo()
    {
        // Get the user's level after login
        $userLevel = auth()->user()->level;

        // Determine the route based on the user's level
        switch ($userLevel) {
            case 'admin':
                return redirect()->route('admin.tables')->with('success', 'Welcome, Admin!'); // Modify the success message as needed
                break;
            case 'author':
                return redirect()->route('author.index')->with('success', 'Welcome, Author!'); // Modify the success message as needed
                break;
            default:
                return $this->redirectTo;
        }
    }

    // Custom login method
    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            // Get the user's level after login
            $userLevel = auth()->user()->level;

            // Determine the route based on the user's level
            switch ($userLevel) {
                case 'admin':
                    return redirect()->route('admin.tables')->with('success', 'Login Successfully');
                    break;
                case 'author':
                    return redirect()->route('author.index')->with('success', 'Login Successfully');
                    break;
                default:
                return redirect()->route('home'); // Alert akan muncul selama 5 detik (5000 milidetik)

            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid email/password combination.');
        }
    }
}
