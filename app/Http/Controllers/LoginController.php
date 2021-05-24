<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        if(!auth()->attempt($data)){
            return response(['data' => ['success' => false,'massage' => 'ایمیل یا پسورد شما اشتباه است.']],403);
        }

        $user             = Auth::user();

        $token = $user->createToken($user->email.'-'.now(), [$user->role]);
        return response([ 'data' => ['success' => true , 'body' => $token ]] , Response::HTTP_OK);
    }
}
