<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectiveRequest;
use App\Http\Requests\UpdateObjectiveRequest;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OdsController extends Controller
{

    /*======================================
    |             OBJECTIVES               |
    ======================================*/
    public function index()
    {
        $customer_id = Auth::user()->customer_id;
        $objectives = Objective::where('customer_id', $customer_id)->get();

        return view('pages.ods.objectives.index', compact('objectives'));
    }

    //PAGE CREATE
    public function create()
    {
        return view('pages.ods.objectives.create');
    }

    public function store(StoreObjectiveRequest $request)
    {
        //1) GET DATA
        $customer_id = Auth::user()->customer_id;

        $data = [
            "title" => $request->title,
            "description" => $request->description,
            "indicator" => $request->indicator,
            "increase" => $request->increase,
            "target" => $request->target,
            "base_year" => $request->base_year,
            "target_year" => $request->target_year,
            "token" => md5($request->title . '+' . date('d/m/Y H:i:s')),
            "customer_id" => $customer_id,
        ];
        //2) STORE DATA
        $objective = new Objective($data);
        $objective->save();
        //3) RETURN REDIRECT
        return redirect(route('ods.index'))->with('message', 'Objetivo creado.')->with('status', 'success');
    }

    //PAGE EDIT
    public function edit($token)
    {
        $objective = Objective::where('token', $token)->first();

        return view('pages.ods.objectives.edit', compact('objective'));
    }

    public function update(UpdateObjectiveRequest $request)
    {
        //1) GET DATA
        $data = [
            "title" => $request->title,
            "description" => $request->description,
            "indicator" => $request->indicator,
            "increase" => $request->increase,
            "target" => $request->target,
            "base_year" => $request->base_year,
            "target_year" => $request->target_year,
        ];
        //2) UPDATE DATA
        $objective = Objective::where('token', $request->token)->update($data);
        //3) RETURN REDIRECT
        return redirect(route('ods.index'))->with('message', 'Objetivo editado.')->with('status', 'success');
    }

    /*======================================
    |         END OBJECTIVES               |
    ======================================*/


    /*======================================
    |               STRATEGY               |
    ======================================*/

    public function strategy($token)
    {
        $objective = Objective::where('token', $token)->first();
        return view('pages.ods.strategy.index', compact('objective'));
    }

    public function strategy_create($token)
    {
        $objective = Objective::where('token', $token)->first();
        return view('pages.ods.strategy.create', compact('objective'));
    }


    /*======================================
    |           END STRATEGY               |
    ======================================*/
}
