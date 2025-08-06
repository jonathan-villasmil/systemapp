<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles']);
        $role = Role::create(['name' => $request->name]);

        return response()->json($role, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Role::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $request->validate(['name' => 'required|string|unique:roles,name,' . $id]);
        $role->update(['name' => $request->name]);

        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    public function assignRole(Request $request, $userId)
    {
        $request->validate(['role' => 'required|string']);
        $user = User::findOrFail($userId);
        $user->assignRole($request->role);

        return response()->json(['message' => 'Role assigned successfully.']);
    }

    public function removeRole(Request $request, $userId)
    {
         $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);

        if ($user->hasRole($request->role)) {
            $user->removeRole($request->role);

            return response()->json([
                'message' => "Rol '{$request->role}' eliminado del usuario.",
            ]);
        }

        return response()->json([
            'message' => "El usuario no tiene el rol '{$request->role}'.",
        ], 404);
    }


     public function getUserRolesPermissions($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json([
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }


}
