<?php

namespace App\Http\Controllers;

use App\Common\Response\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = JWTAuth::fromUser($user);

            return $this->successResponse('User registered successfully', [
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Registration failed', 500, [$e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        if (!$token = Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse('Login successful', [
            'user' => Auth::user(),
            'token' => $token
        ]);
    }

    public function logout()
    {
        try {
            Auth::logout();
            return $this->successResponse('Successfully logged out');
        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed', 500, [$e->getMessage()]);
        }
    }
}
