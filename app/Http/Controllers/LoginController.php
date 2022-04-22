<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function create()
    {
        return view('login');
    }

    public function store()
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        return redirect()->to('/groups');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->to('/login');
    }
}
