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
          'last_name' => $request->get('first_name'),
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
        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['message' => 'Wrong email or password'], 422);
        }
        return response()
            ->json(['status' => true, 'message' => 'Logged in successfully', 'token' => $token]);
    }

    public function customer(Request $request)
    {
        $customer = JWTAuth::toUser($request->token);
        if ($customer) {
            return response($customer, Response::HTTP_OK);
        }
        return response(null, Response::HTTP_BAD_REQUEST);
    }
}
