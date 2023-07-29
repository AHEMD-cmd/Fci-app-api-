<?php

namespace App\Http\Controllers\Api;

use App\Models\Father;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FatherLoginController extends Controller
{

    public function store(Request $request)
    {


        $father = Father::where('email', $request->post('email'))->first();
        if($father && Hash::check($request->post('password'), $father->password)){

            $token = $father->createToken($request->header('user-agent'));

            return[
                'token' => $token->plainTextToken,
                'status' => 200
            ];
        }else{
            return[

                'status' => '401'
            ];
        }

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
