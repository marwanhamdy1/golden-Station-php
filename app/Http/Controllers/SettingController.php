<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('settings.index');
    }

    public function users()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('settings.users', compact('users', 'roles'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('settings.create_user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        return redirect()->route('settings.users')->with('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('settings.edit_user', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|exists:roles,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles([$request->role]);
        return redirect()->route('settings.users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('settings.users')->with('success', 'User deleted successfully!');
    }

    public function listRoles()
    {
        $roles = Role::with('permissions')->get();
        return view('settings.roles', compact('roles'));
    }

    public function createRole()
    {
        $permissions = Permission::all();
        return view('settings.create_role', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->route('settings.roles')->with('success', 'Role created successfully!');
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('settings.edit_role', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('settings.roles')->with('success', 'Role updated successfully!');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('settings.roles')->with('success', 'Role deleted successfully!');
    }

    public function updateTimezone(Request $request)
    {
        if (!auth()->user() || !auth()->user()->hasRole('superadmin')) {
            abort(403);
        }
        $request->validate([
            'timezone' => 'required|string',
        ]);
        Setting::updateOrCreate(['key' => 'timezone'], ['value' => $request->timezone]);
        cache()->forget('app_timezone');
        return redirect()->back()->with('success', 'Timezone updated successfully!');
    }
}
