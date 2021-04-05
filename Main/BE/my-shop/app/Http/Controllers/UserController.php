<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function register(Request $request){
        $user = $this->user->create([
          'first_name' => $request->get('first_name'),
          'last_name' => $request->get('last_name'),
          'address' => $request->get('address'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully',
            'data'=>$user
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getUserInfo(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        try {
            JWTAuth::parseToken()->invalidate($token);
            return response()->json(['message' => 'logged out']);;
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'message' => "Expired Token"
            ], 401);
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'message' => "Invalid Token"
            ], 401);
        } catch (JWTException $exception) {
            return response()->json([
                'message' => "JWT Error"
            ], 500);
        }
    }
}
