<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function logout(Request $request){
        $this->doLogout($request);
        return redirect('/home');
    }
}