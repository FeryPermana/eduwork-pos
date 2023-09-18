<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get users
        $users = User::filter(request())->with('roles')->latest()->paginate(10);

        return view('apps/users/index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get roles
        $roles = Role::all();
        $method = "store";
        $url = route('apps.users.store');
        //return inertia
        return view('apps/users/_form', [
            'roles' => $roles,
            'method' => $method,
            'url' => $url
        ]);
    }

    public function store(Request $request)
    {
        /**
         * Validate request
         */
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        /**
         * Create user
         */
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //assign roles to user
        $user->assignRole($request->roles);

        //redirect
        return redirect()->route('apps.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get user
        $user = User::with('roles')->findOrFail($id);

        //get roles
        $roles = Role::all();

        $method = "update";
        $url = route('apps.users.update', $id);

        //return inertia
        return view('apps/users/_form', [
            'user' => $user,
            'roles' => $roles,
            'method' => $method,
            'url' => $url
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        /**
         * validate request
         */
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed'
        ]);

        /**
         * check password is empty
         */
        if ($request->password == '') {

            $user->update([
                'name'     => $request->name,
                'email'    => $request->email
            ]);
        } else {

            $user->update([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }

        //assign roles to user
        $user->syncRoles($request->roles);

        //redirect
        return redirect()->route('apps.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find user
        $user = User::findOrFail($id);

        //delete user
        $user->delete();
    }
}
