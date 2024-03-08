<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PSpell\Config;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       
        // return  Auth::user();
        return $this->respondWithToken($token);
    }
    public function user(){
        return Auth::user();
    }
    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh(){

    }
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'expres_in' =>  Auth::factory()->getTTL() * 60
        ]);
    }
}
