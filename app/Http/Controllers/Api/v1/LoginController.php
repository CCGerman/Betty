<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\UploaderHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $request->user()->createToken($request->device)->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Success'
        ], 200);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }

}
