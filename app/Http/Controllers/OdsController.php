<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectiveRequest;
use App\Http\Requests\StoreStrategyRequest;
use App\Http\Requests\UpdateObjectiveRequest;
use App\Http\Requests\UpdateStrategyRequest;
use App\Models\Evaluation;
use App\Models\Evaluation_file;
use App\Models\Objective;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        if ($request->strategy) {
            return redirect(route('ods.strategy.create', $objective->token))->with('message', 'Objetivo creado.')->with('status', 'success');
        }
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
        $objective = Objective::where('token', $request->token)->first();
        //3) RETURN REDIRECT
        if ($request->strategy) {
            return redirect(route('ods.strategy.index', $objective->token))->with('message', 'Objetivo editado.')->with('status', 'success');
        }

        return redirect(route('ods.index'))->with('message', 'Objetivo editado.')->with('status', 'success');
    }

    //PAGE EVALUATE
    public function evaluate($token)
    {
        $objective = Objective::where('token', $token)->first();
        $strategies = Strategy::where('objective_id', $objective->id)->get();

        return view('pages.ods.objectives.evaluate', compact('objective', 'strategies'));
    }

    public function evaluate_save(Request $request)
    {
        $rows =  $request->rows;

        //try {
        foreach ($rows as $key => $row) {

            if ($row['strategy'] != null) { //prevent NULL VALUES
                //1) CHECK IF NEED UPDATE OR STORE
                $evaluation = Evaluation::where('token', $row['id'])->exists();

                if ($evaluation && $row['id'] != 0) {

                    //update
                    $data = [
                        'year' => $row["year"],
                        'value' => $row["value"],
                        'strategy_id' => $row['strategy']['id'],
                    ];

                    //3) VALIDATE DATA
                    $rules = [
                        'year' => ['required', 'numeric'],
                        'value' => ['required', 'numeric'],
                        'strategy_id' => ['required', 'numeric'],
                    ];

                    $validator = Validator::make($data, $rules);


                    if (!$validator->fails()) {
                        //4) SAVE DATA
                        $evaluation = Evaluation::where('token', $row['id'])->update($data);
                        $files = $row['files'];

                        foreach ($files as $key => $file) {

                            $checkFile = Evaluation_file::where('path', $file['path'])->exists();
                            if ($checkFile) {
                                //upload
                                Evaluation_file::where('path', $file['path'])->update(
                                    [
                                        "name" => $file['name'],
                                        "path" => $file['path'],
                                    ]
                                );
                            } else {
                                //save
                                $evaluation_id = Evaluation::where('token', $row['id'])->first();

                                $file_save = new Evaluation_file(
                                    [
                                        "name" => $file['name'],
                                        "token" => md5($file['name']),
                                        "path" => $file['path'],
                                        "evaluation_id" => $evaluation_id->id,
                                    ]
                                );

                                $file_save->save();
                            }
                        }
                    }
                } else {

                    //save
                    //2) GET DATA

                    $data = [
                        'year' => $row["year"],
                        'value' => $row["value"],
                        'strategy_id' => $row['strategy']['id'],
                        'token' => md5($row['strategy']['id'] . '+' . $row['value'] . '+' . date('d/m/Y H:i:s'))
                    ];

                    //3) VALIDATE DATA
                    $rules = [
                        'year' => ['required', 'numeric'],
                        'value' => ['required', 'numeric'],
                        'strategy_id' => ['required', 'numeric'],
                        'token' => ['required', 'string'],
                    ];
                    $validator = Validator::make($data, $rules);

                    if (!$validator->fails()) {

                        //4) SAVE DATA
                        $evaluation = new Evaluation($data);
                        $evaluation->save();

                        $files = $row['files'];

                        foreach ($files as $key => $file) {

                            $checkFile = Evaluation_file::where('file', $file['path'])->exists();
                            if ($checkFile) {
                                //upload
                                Evaluation_file::where('path', $file['path'])->update(
                                    [
                                        "name" => $file['name'],
                                        "path" => $file['path'],
                                    ]
                                );
                            } else {
                                //save

                                $file_save = new Evaluation_file(
                                    [
                                        "name" => $file['name'],
                                        "token" => md5($file['name']),
                                        "path" => $file['path'],
                                        "evaluation_id" => $evaluation->id,
                                    ]
                                );

                                $file_save->save();
                            }
                        }
                    }
                }
            }
        }

        $response = [
            'status' => 'success',
            'message' => 'Evaluaciones guardadas.'
        ];

        return response()->json($response);
        /*} catch (\Throwable $th) {

            $response = [
                'status' => 'error',
                'message' => 'Se ha producido un error durante la carga de datos.'
            ];

            return response()->json($response);
        }*/
    }

    public function get_evaluations(Request $request)
    {
        $objective = Objective::where('token', $request->token)->first();
        $strategies = Strategy::where('objective_id', $objective->id)->get();

        $strategies_ids = $strategies->pluck('id');

        $evaluations = Evaluation::whereIn('strategy_id', $strategies_ids)->with('strategy')->with('files')->orderBy('year', 'DESC')->get();

        $response = [
            "evaluations" => $evaluations,
        ];

        return response()->json($response);
    }

    public function save_file(Request $request)
    {
        $files = $request->file('file');
        $path = storage_path('/app/public') . '/evaluation/'; //EVALUACION
        $tokens = [];
        $paths = [];

        foreach ($files as $file) {
            $token = md5($file->getClientOriginalName() . date('d/m/Y H:i:s'));
            $ext = $file->guessExtension();
            $fileName = $token . '.' . $ext;
            $file->move($path, $fileName);
            array_push($tokens, $token);
            array_push($paths, '/evaluation/' . $fileName);
        }

        return response()->json(['tokens' => $tokens, 'paths' => $paths]);
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
            "increase" => $request->increase,
            "target" => $request->target,
            "base_year" => $request->base_year,
            "target_year" => $request->target_year,
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
            "increase" => $request->increase,
            "target" => $request->target,
            "base_year" => $request->base_year,
            "target_year" => $request->target_year,
        ];

        $strategy = Strategy::where('token', $request->token)->update($data);


        return redirect(route('ods.strategy.index', $objective->token))->with('message', 'Estrategia editada.')->with('status', 'success');
    }


    /*======================================
    |           END STRATEGY               |
    ======================================*/
}
