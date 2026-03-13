<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * GET /roles
     * List all roles.
     */
    public function index(): JsonResponse
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'data'    => $roles,
        ]);
    }

    /**
     * POST /roles
     * Create a new role.
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255|unique:roles,name'
             ]);

        $role = Role::create([
            'name'        => $request->input('name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'data'    => $role,
        ], 201);
    }

    /**
     * GET /roles/{id}
     * Show a single role.
     */
    public function show(int $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $role,
        ]);
    }

    /**
     * PUT /roles/{id}
     * Update an existing role.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }

        $this->validate($request, [
            'name'        => 'sometimes|required|string|max:255|unique:roles,name,' . $id
                ]);

        $role->fill($request->only(['name', 'description']));
        $role->save();

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'data'    => $role,
        ]);
    }

    /**
     * DELETE /roles/{id}
     * Delete a role.
     */
    public function destroy(int $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }
}
