<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get roles
        $roles = Role::when(request()->search, function ($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->search . '%');
        })->with('permissions')->latest()->paginate(10);

        return view('apps.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        $method = "store";
        $url = route('apps.roles.store');

        return view('apps/roles/_form', [
            'permissions' => $permissions,
            'method' => $method,
            'url' => $url,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        //create role
        $role = Role::create(['name' => $request->name]);

        //assign permissions to role
        $role->givePermissionTo($request->permissions);

        //redirect
        return redirect()->route('apps.roles.index')->with('success', 'Created role successfully');
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
        $role = Role::with('permissions')->findOrFail($id);
        $method = "update";
        $url = route('apps.roles.update', $id);

        //get permission all
        $permissions = Permission::all();

        return view('apps/roles/_form', [
            'permissions' => $permissions,
            'method' => $method,
            'url' => $url,
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        /**
         * validate request
         */
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        //update role
        $role->update(['name' => $request->name]);

        //sync permissions
        $role->syncPermissions($request->permissions);

        //redirect
        return redirect()->route('apps.roles.index')->with('success', 'Updated role successfully');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find role by ID
        $role = Role::findOrFail($id);

        //delete role
        $role->delete();
    }
}
