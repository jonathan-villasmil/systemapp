<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Response;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions']);
        $permission = Permission::create(['name' => $request->name]);

        return response()->json($permission, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Permission::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate(['name' => 'required|string|unique:permissions,name,' . $id]);
        $permission->update(['name' => $request->name]);

        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }



    public function givePermission(Request $request, $userId)
    {
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $user = User::findOrFail($userId);
        $user->givePermissionTo($request->permission);

        return response()->json(['message' => 'Permiso asignado correctamente']);
    }

    public function revokePermission(Request $request, $userId)
    {
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $user = User::findOrFail($userId);
        $user->revokePermissionTo($request->permission);

        return response()->json(['message' => 'Permiso revocado correctamente']);
    }

}
