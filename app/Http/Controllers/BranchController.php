<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $customer_id = Auth::user()->customer->id;

        $branches = Branch::where('customer_id', $customer_id)->get();

        return view('pages.branch.index', compact('branches'));
    }

    //PAGE CREATE
    public function create()
    {
        $customer_id = Auth::user()->customer->id;
        $users = User::where('customer_id', $customer_id)->get();

        return view('pages.branch.create', compact('users'));
    }

    public function store(StoreBranchRequest $request)
    {
        $customer_id = Auth::user()->customer->id;

        //1)GET DATA
        $data = [
            "name" => $request->name,
            "location" => $request->location,
            "coordinates" => $request->coordinates,
            "token" => md5($request->name . "+" . date('d/m/Y H:i:s')),
            "customer_id" => $customer_id,
        ];

        $users = $request->users;

        //2)STORE DATA

        $branch = new Branch($data);
        $branch->save();
        $branch->users()->sync($users);

        //3) RETURN REDIRECT
        return redirect(route('branches.index'))->with('status', 'success')->with('message', 'Centro creado.');
    }

    //PAGE EDIT
    public function edit($token)
    {

        $customer_id = Auth::user()->customer->id;
        $users = User::where('customer_id', $customer_id)->get();
        $branch = Branch::where('token', $token)->with('users')->first();

        return view('pages.branch.edit', compact('users', 'branch'));
    }

    public function update(UpdateBranchRequest $request)
    {
        //1) GET DATA
        $branch = Branch::where('token', $request->token)->first();

        $data = [
            "name" => $request->name,
            "location" => $request->location,
            "coordinates" => $request->coordinates,
        ];

        $users = $request->users;
        //2) UPDATE DATA

        $branch = Branch::where('token', $request->token)->update($data);

        $branch = Branch::where('token', $request->token)->first();
        $branch->users()->sync($users);

        //3) RETURN REDIRECT
        return redirect(route('branches.index'))->with('status', 'success')->with('message', 'Centro editado.');
    }
}
