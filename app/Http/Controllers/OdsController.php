<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectiveRequest;
use App\Http\Requests\StoreStrategyRequest;
use App\Http\Requests\UpdateObjectiveRequest;
use App\Http\Requests\UpdateStrategyRequest;
use App\Models\Objective;
use App\Models\Strategy;
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
        $strategies = Strategy::where('objective_id', $objective->id)->get();
        return view('pages.ods.strategy.index', compact('objective', 'strategies'));
    }

    public function strategy_create($token)
    {
        $objective = Objective::where('token', $token)->first();
        return view('pages.ods.strategy.create', compact('objective'));
    }

    public function strategy_store(StoreStrategyRequest $request, $token)
    {
        //1) GET DATA
        $objective = Objective::where('token', $token)->first();

        $data = [
            "title" => $request->title,
            "indicator" => $request->indicator,
            "description" => $request->description,
            "performances" => $request->performances,
            "token" => md5($request->title . '+' . date('Y')),
            "objective_id" => $objective->id
        ];
        //2) STORE DATA
        $strategy = new Strategy($data);
        $strategy->save();
        //3) RETURN REDIRECT
        return redirect(route('ods.strategy.index', $objective->token))->with('message', 'Estrategia creada.')->with('status', 'success');
    }


    public function strategy_edit($token_objective, $token_strategy)
    {
        //1) GET DATA
        $objective = Objective::where('token', $token_objective)->first();
        $strategy = Strategy::where('token', $token_strategy)->first();

        return view('pages.ods.strategy.edit', compact('objective', 'strategy'));
    }


    public function strategy_update($token, UpdateStrategyRequest $request)
    {
        //1) GET DATA
        $objective = Objective::where('token', $token)->first();
        $strategy = Strategy::where('token', $request->token)->first();

        $data = [
            "title" => $request->title,
            "indicator" => $request->indicator,
            "description" => $request->description,
            "performances" => $request->performances,
        ];

        $strategy = Strategy::where('token', $request->token)->update($data);


        return redirect(route('ods.strategy.index', $objective->token))->with('message', 'Estrategia editada.')->with('status', 'success');
    }


    /*======================================
    |           END STRATEGY               |
    ======================================*/
}
