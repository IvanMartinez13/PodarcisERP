<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\UserMailable;
use App\Models\Branch;
use App\Models\Departament;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $user = Auth::user();

        $modules = Auth::user()->customer->modules;

        $branches = Branch::where('customer_id', $user->customer_id)->with('departaments')->get();

        $departaments = Departament::whereHas('branches', function ($q) use ($user) {
            $q->where('customer_id', $user->customer_id);
        })->get();

        return view('pages.user.create', compact('modules', 'branches', 'departaments'));
    }

    //PAGE STORE
    public function store(StoreUserRequest $request)
    {
        //1) GET DATA

        $customer = Auth::user()->customer;

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
        $departaments = $request->departaments;
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
        $user->departaments()->sync($departaments);
        
        //SEND MAIL
        $mail = new UserMailable($user, $request->password);
        Mail::to($user->email)->send($mail);

        //3) RETURN REDIRECT
        return redirect(route('users.index'))->with('message', 'Usuario creado.')->with('status', 'success');
    }

    //PAGE UPDATE
    public function edit($token)
    {
        $user = User::where('token', $token)->with('branches')->with('departaments')->first();

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
        $departaments = $request->departaments;

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
        $user->departaments()->sync($departaments);

        //SEND MAIL
        if ($request->password != null) {
            $mail = new UserMailable($user, $request->password);
        }else{
            $mail = new UserMailable($user, null);
        }
        
        Mail::to($user->email)->send($mail);

        //3) RETURN REDIRECT
        return redirect(route('users.index'))->with('message', 'Usuario editado.')->with('status', 'success');
    }


    public function impersonate($id)
    {
        Auth::user()->leaveImpersonation();
        $user = User::where('token', $id)->first();

        Auth::user()->impersonate($user);
        return redirect('/dashboard');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('pages.user.profile', compact('user'));
    }

    public function profile_update($token, Request $request)
    {
        //1) GET DATA
        $user = User::where('token', $token)->first();

        $rules =  [
            //DATOS DEL USUARIO
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],

        ];



        $attributes = [
            //DATOS DEL USUARIO
            'name' => 'Nombre',
            'email' => 'Email',
            'password' => 'Contraseña',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator);
        }

        //2) VALIDATE DATA
        $data = [
            "name" => $request->name,
            "email" => $request->email,
        ];

        if ($request->password != null) {
            $data = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ];
        }

        $user = User::where('token', $token)->update($data);

        //3) RETURN REDIRECT
        return redirect(route('profile'))->with('message', 'Perfil editado.')->with('status', 'success');
    }

    public function profile_photo($token, Request $request)
    {
        $files = $request->file('file');
        $path = storage_path('/app/public') . '/users/'; //EVALUACION

        foreach ($files as $file) {
            $ext = $file->guessExtension();
            $fileName = auth()->user()->token . '.' . $ext;
            $file->move($path, $fileName);
        }

        $user = User::where('token', $token)->update(
            ['profile_photo' => '/users/' . $fileName]
        );


        return response()->json(['status' => 'success', 'message' => 'Imagen de perfil actualizada.']);
    }
}
