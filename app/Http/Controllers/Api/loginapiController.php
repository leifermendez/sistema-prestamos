<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Session;

class loginApiController extends Controller
{

    public function loginApi(Request $request, response $response)
    {
            $credentials = $request->only('email', 'password');
            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            $dataUser = User::where('email',$request->email)->first();

            $token = JWTAuth::fromUser($dataUser);
            $return = [
                'token' => $token,
                'user' => $dataUser
            ];
            return response()->json($return);
    }

    public function logout_api(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        Session::flush();
    
        $response = array(
            'status' => 'success',
            'msj' => 'Logout',
            'code' => 0
        );
        return response()->json($response);
    }

}
