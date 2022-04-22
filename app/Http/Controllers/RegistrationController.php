<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'age' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password', 'age']));

        auth()->login($user);

        return redirect()->to('/groups');
    }

}
