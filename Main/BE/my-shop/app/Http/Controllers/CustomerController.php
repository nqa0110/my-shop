<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Customer;
use JWTAuth;
use Config;
use Auth;

class CustomerController extends Controller
{
    private $customer;
    public function __construct(Customer $customer)
    {
        Config::set('jwt.user', Customer::class);
        Config::set('auth.providers', ['users' => ['driver' => 'eloquent', 'model' => Customer::class , ]]);
        $this->customer = $customer;
    }

    //Random password
    public function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    public function register(Request $request)
    {
        $customer = $this->customer->create([
          'first_name' => $request->get('first_name'),
          'last_name' => $request->get('last_name'),
          'address' => $request->get('address'),
          'email' => $request->get('email'),
          'email_verified_at' => $request->get('email_verified_at'),
          'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
            'status'=> 200,
            'message'=> 'Customer created successfully',
            'data'=>$customer
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($input)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getCustomerInfo (Request $request)
    {
        $customer = JWTAuth::toUser($request->token);
        if ($customer) {
            return response($customer, Response::HTTP_OK);
        }
        return response(null, Response::HTTP_BAD_REQUEST);
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
