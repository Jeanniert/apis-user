<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles.permissions'])->get();;

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
            'phone' => 'required|string|max:15',
            'role' => 'required|string|exists:roles,name'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
            $new_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'age' => $request->age,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'dni' => $request->dni,
                'address' => $request->address,
                'country' => $request->country,
                'phone' => $request->phone,
            ]);
            $new_user->assignRole($request->role);
            return response()->json([
                'status' => true,
                'data' => $new_user,
                'message' => 'User successfully created!'
            ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $update_user = User::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $update_user->id,
            'age' => 'required|integer',
            'birthdate' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'dni' => 'required|string|max:20|unique:users,dni,' . $update_user->id,
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|exists:roles,name'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $update_user->update($request->input());
        $update_user->assignRole($request->role);
        return response()->json([
            'status' => true,
            'data' => $update_user,
            'message' => 'User successfully updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User successfully eliminated!'
        ], 204);
    }
}
