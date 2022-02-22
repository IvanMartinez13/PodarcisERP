<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class UserController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer->id;
        $users = User::where('customer_id', $customer)->get();

        return view('pages.user.index', compact('users'));
    }

    //PAGE CREATE
    public function create()
    {
        $modules = Auth::user()->customer->modules;

        $branches = Branch::where('customer_id', Auth::user()->customer_id)->get();

        return view('pages.user.create', compact('modules', 'branches'));
    }

    //PAGE STORE
    public function store(StoreUserRequest $request)
    {
        //1) GET DATA

        $customer = Auth::user()->customer->id;

        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "token" => md5($request->username . "+" . date('d/m/Y H:i:s')),
            "customer_id" => $customer->id
        ];

        $branches = $request->branches;

        $permissions = ($request->permissions != null) ? $request->permissions : [];

        //2) STORE DATA
        $user = new User($data);
        $user->save();

        foreach ($permissions as $permission) {
            //Si no existe se crea el permiso
            $check = Permission::where('name', $permission)->first();

            if ($check == null) {
                $permission = Permission::create(['guard_name' => 'web', 'name' => $permission]);
            }
        }

        $user->syncPermissions($permissions);
        $user->branches()->sync($branches);

        //3) RETURN REDIRECT
        return redirect(route('users.index'))->with('message', 'Usuario creado.')->with('status', 'success');
    }

    //PAGE UPDATE
    public function edit($token)
    {
        $user = User::where('token', $token)->with('branches')->first();

        $branches = Branch::where('customer_id', $user->customer_id)->get();

        $modules = Auth::user()->customer->modules;

        $permissions = $user->getAllPermissions();

        return view('pages.user.edit', compact('user', 'modules', 'permissions', 'branches'));
    }

    public function update(Request $request)
    {
        //1) GET DATA
        $user = User::where('token', $request->token)->first();

        $rules =  [
            //DATOS DEL USUARIO
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user->id, 'id')],
            'position' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            "token" => ["required", "string"],
            "branches" => ["nullable", "array"],
        ];

        $attributes = [
            //DATOS DEL USUARIO
            'name' => 'Nombre',
            'username' => 'Username',
            'email' => 'Email',
            'position' => 'Cargo',
            'password' => 'Contraseña',
            "token" => "Token",
            "branches" => "Centros"
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);



        if ($request->password != null) {
            $data = [
                'name' => $request->name,
                'position' => $request->position,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
        } else {
            $data = [
                'name' => $request->name,
                'position' => $request->position,
                'username' => $request->username,
                'email' => $request->email,

            ];
        }

        $branches = $request->branches;

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator);
        }

        $permissions = ($request->permissions != null) ? $request->permissions : [];

        //2) STORE DATA
        $user =  User::where('token', $request->token);
        $user->update($data);

        foreach ($permissions as $permission) {
            //Si no existe se crea el permiso
            $check = Permission::where('name', $permission)->first();

            if ($check == null) {
                $permission = Permission::create(['guard_name' => 'web', 'name' => $permission]);
            }
        }
        $user =  User::where('token', $request->token)->first();
        $user->syncPermissions($permissions);
        $user->branches()->sync($branches);

        //3) RETURN REDIRECT
        return redirect(route('users.index'))->with('message', 'Usuario editado.')->with('status', 'success');
    }
}
