<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function Register(RegisterRequest $request)
    {
        $role = 'admin';

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $role,
            'password'   => bcrypt($request->password),
        ]);
        $token = $user->createToken($user->email.'-'.now(), [$role]);
        return response([ 'data' => ['success' => true , 'body' => $token ]] , Response::HTTP_OK);
    }
}
