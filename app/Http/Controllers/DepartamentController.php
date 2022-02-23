<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartamentsRequest;
use App\Http\Requests\UpdateDepartamentsRequest;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class DepartamentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $departaments = Departament::whereHas('branches', function ($q) use ($user) {
            $q->where('customer_id', $user->customer_id);
        })->get();

        return view('pages.departaments.index', compact('departaments'));
    }

    //PAGE CREATE
    public function create()
    {
        $user = Auth::user();
        $branches = Branch::where('customer_id', $user->customer_id)->with('users')->get();
        $users = User::where('customer_id', $user->customer_id)->get();

        return view('pages.departaments.create', compact('users', 'branches'));
    }

    public function store(StoreDepartamentsRequest $request)
    {
        //1) GET DATA

        $data = [
            "name" => $request->name,
            "token" => md5($request->name . date('d/m/Y H:i:s')),
        ];

        $branches = $request->branches;
        $users = $request->users;
        //2) STORE DATA
        $departaments = new Departament($data);
        $departaments->save();

        $departaments->branches()->sync($branches);
        $departaments->users()->sync($users);
        //3) RETURN REDIRECT
        return redirect(route('departaments.index'))->with('message', 'Departamento creado.')->with('status', 'success');
    }


    //PAGE EDIT
    public function edit($token)
    {
        $user = Auth::user();

        $departament = Departament::where('token', $token)->with('users')->with('branches.users')->first();
        $branches = Branch::where('customer_id', $user->customer_id)->with('users')->get();
        $users = User::where('customer_id', $user->customer_id)->get();

        return view('pages.departaments.edit', compact('users', 'branches', 'departament'));
    }

    public function update(UpdateDepartamentsRequest $request)
    {
        //1) GET DATA
        $departament = Departament::where("token", $request->token);
        $data = [
            "name" => $request->name,
        ];

        $branches = $request->branches;
        $users = $request->users;
        //2) STORE DATA
        $departament = $departament->update($data);
        $departament = Departament::where("token", $request->token)->first();

        $departament->branches()->sync($branches);
        $departament->users()->sync($users);
        //3) RETURN REDIRECT
        return redirect(route('departaments.index'))->with('message', 'Departamento editado.')->with('status', 'success');
    }
}
