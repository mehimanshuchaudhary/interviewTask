<?php

namespace App\Http\Controllers;

use App\DataTables\AccessDataTable;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AccessDataTable $dataTable)
    {
        return $dataTable->render('access.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $permissions = \Spatie\Permission\Models\Permission::all();
         return view('access.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = \Spatie\Permission\Models\Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('access.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('access.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('access.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }
}
