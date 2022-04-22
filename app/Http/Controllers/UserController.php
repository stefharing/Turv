<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(){

        if (Auth::check()) {
            if (Auth::user()->id){
                $user = Auth::user();
                return view('account', compact('user'));
            }
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
