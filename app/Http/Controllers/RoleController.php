<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Role::with('permissions')->get();
        $role = Role::paginate(10);
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $role= Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        return response()->json([
            'status' => true,
            'data' => $role,
            'message' => 'Role successfully created'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $rules = [
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $role->update($request->input());
        $role->givePermissionTo($request->permissions);
        return response()->json([
            'status' => true,
            'data' => $role,
            'message' => 'Role successfully updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete(); 
        return response()->json([
            'status' => true,
            'message' => 'Role successfully eliminated'
        ], 200);
        
    }
}
