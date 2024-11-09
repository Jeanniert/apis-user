<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function guard()
    {
        return Auth::guard('api');
    }

    public function login(Request $request)
    {

        $rules = [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

            $credentials = $request->only('email', 'password');
            if (Auth::guard('api')->check($credentials)) {
            $rules = [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6',
                'email' => 'required|string|email|max:255|unique:users',
                'age' => 'required|integer',
                'birthdate' => 'required|date',
                'gender' => 'required|in:M,F,O',
                'dni' => 'required|string|max:20|unique:users',
                'address' => 'required|string|max:255',
                'country' => 'required|string|max:100',
                'phone' => 'required|string|max:15'
            ];

            $validator = Validator::make($request->input(), $rules);
            return response()->json([
                'status' => false,
                'errors' => ['No autorizado!']
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Usuario autenticado con éxito!',
            'data' => $user,
            'token' => $user->createToken('auth-tokens')->plainTextToken
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Usuario desconectado con éxito!'
        ], 200);
    }
}
