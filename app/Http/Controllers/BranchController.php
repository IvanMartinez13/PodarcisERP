<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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
}
