<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Departament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
