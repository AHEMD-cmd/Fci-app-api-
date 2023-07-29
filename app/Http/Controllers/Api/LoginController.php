<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->post('email'))->first();
        if($user && Hash::check($request->post('password'), $user->password)){

            $token = $user->createToken($request->header('user-agent'));
        }

        return[
            'status' => 200,
            'token' => $token->plainTextToken
        ];
    }




    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();

        return[
            'message' => 'token deleted'
        ];
    }
}
