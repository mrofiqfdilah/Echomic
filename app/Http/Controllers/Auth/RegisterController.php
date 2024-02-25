<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'tgl_lahir' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:laki-laki,perempuan'],
        ]);
    }

    protected function create(array $data)
    {
        // Set nilai default "user" jika bidang level tidak ada dalam data
        $data['level'] = $data['level'] ?? 'user';

        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tgl_lahir' => $data['tgl_lahir'],
            'level' => $data['level'],
            'gender' => $data['gender'],
        ]);
    }
}
