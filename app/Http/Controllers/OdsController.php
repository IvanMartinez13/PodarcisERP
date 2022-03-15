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
use Exception;
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
        $strategy = Strategy::where('token', $token)->first();
        $objective = Objective::where('id', $strategy->objective_id)->first();

        return view('pages.ods.objectives.evaluate', compact('objective', 'strategy'));
    }

    public function evaluate_save(Request $request)
    {
        //1) GET DATA
        $evaluations =  $request->data;
        $token = $request->token;
        $strategy = Strategy::where('token', $token)->first();

        //try{

            foreach ($evaluations as $key => $evaluation) {

                $checkEvaluation = Evaluation::where('token', $evaluation['id'])->exists();
    
                if ($checkEvaluation) {
    
                    //2)PREPARE DATA
                    $data = [
                        'year' => $evaluation['year'],
                        'value' => $evaluation['value']
                    ];
    
                    $rules = [
                        'year' => ['required', 'numeric'],
                        'value' => ['required', 'numeric'],
                    ];
    
                    $validator = Validator::make($data, $rules);
    
                    if (!$validator->fails() || $evaluation['delete'] != true) {
                        //3) UPDATE DATA
                        $update = Evaluation::where('token', $evaluation['id']);
                        $update->update($data);
                    }

                    if ($evaluation['delete'] == true) {
                        $update = Evaluation::where('token', $evaluation['id'])->delete();
                    }

                    $update = Evaluation::where('token', $evaluation['id'])->first();
                    foreach ($evaluation['files'] as $key => $file) {
                        //CHECK DATA
                        if( isset($file['token']) )
                        {
                            $data=[
                                'name' => $file['name'],
                               
                            ];

                            $file = Evaluation_file::where('token', $file['token'])->update($data);
                        }else{

                            $data=[
                                'name' => $file['name'],
                                'path' => $file['path'],
                                'evaluation_id' => $update->id,
                                'token' => md5( $file['name'].'+'.date('d/m/Y H:i:s') ),
                            ];

                            $file = new Evaluation_file($data);
                            $file->save();
                        }
                    }
    
    
    
                }else{
    
                    //2)PREPARE DATA
                    $data = [
                        'year' => $evaluation['year'],
                        'value' => $evaluation['value'],
                        'strategy_id' => $strategy->id,
                        'token' => md5($evaluation['year'].'+'.$evaluation['value'].'+'.date('d/m/Y H:i:s')),
                    ];
    
                    $rules = [
                        'year' => ['required', 'numeric'],
                        'value' => ['required', 'numeric'],
                    ];
    
                    $validator = Validator::make($data, $rules);
    
                    if (!$validator->fails()  || $evaluation['delete'] != true) {
                        //3) STORE DATA
                        $store = new Evaluation($data);
                        $store->save();
                    }

                    foreach ($evaluation['files'] as $key => $file) {
                        //CHECK DATA
                        $data = [
                            'name' => $file['name'],
                            'path' => $file['path'],
                            'evaluation_id' => $store->id,
                            'token' => md5( $file['name'].'+'.date('d/m/Y H:i:s') ),
                        ];

                        $file = new Evaluation_file($data);
                        $file->save();
                    }
    
    
    
                }
            }

            //4) RETURN RESPONSE
            $response = [
                'status' => 'success',
                'message' => 'Evaluaciones guardadas.'
            ];

            return response()->json($response);

        /*}catch(\Throwable $th){

            //4) RETURN RESPONSE
            $response = [
                'status' => 'error',
                'message' => 'Se ha producido un error.'
            ];

            return response()->json($response);
        }*/



        



    }

    public function get_evaluations(Request $request)
    {
        $strategy = Strategy::where('token', $request->token)->first();

        $evaluations = Evaluation::where('strategy_id', $strategy->id)->with('strategy')->with('files')->orderBy('year', 'DESC')->get();

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
            "token" => md5($request->title . '+' . date('d/m/Y H:i:s')),
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

    public function dashboard()
    {
        $user = Auth::user();
        $customer_id = $user->customer_id;

        $objectives = Objective::where('customer_id', $customer_id)->get();

        $response = [
            "user" => $user,
            "objectives" => $objectives,
        ];

        return response()->json($response);
    }

    public function objective_evolution(Request $request)
    {
        $objective = Objective::where('token', $request->token)->first();

        $strategies = Strategy::where("objective_id", $objective->id)->get();

        $strategies_id = $strategies->pluck('id');

        $evaluations = Evaluation::whereIn('strategy_id', $strategies_id)->orderBy('year', 'ASC')->get();

        $years = $evaluations->unique('year')->pluck('year');

        $evaluations_array = [];

        //año
        foreach ($years as $year) {
            //evaluaciones
            foreach ($evaluations as $evaluation) {
                if ($year == $evaluation->year) {

                    if (!isset($evaluations_array[$year][0])) {

                        $evaluations_array[$year] = [];
                    }

                    array_push($evaluations_array[$year], $evaluation);
                }
            }
        }


        //RETURN DATA

        $response = [
            "evaluations" => $evaluations_array,
            "years" => $years
        ];

        return response()->json($response);
    }

    public function evolution_chart(Request $request)
    {
        $token = $request->token;
        $strategy = Strategy::where('token', $request->token)->first();

        $evaluations = Evaluation::where('strategy_id', $strategy->id)->orderBy('year', 'ASC')->get();

        $years = $evaluations->unique('year')->pluck('year');

        $evaluations_array = [];

        //año
        foreach ($years as $year) {
            //evaluaciones
            foreach ($evaluations as $evaluation) {
                if ($year == $evaluation->year) {

                    if (!isset($evaluations_array[$year][0])) {

                        $evaluations_array[$year] = [];
                    }

                    array_push($evaluations_array[$year], $evaluation);
                }
            }
        }

        $response = [
            "evaluations" => $evaluations_array,
            "years" => $years
        ];

        return response()->json($response);
    }



    //GO TO PAGE RECYCLE EVALUATIONS
    public function deleted_evaluations($token){
        $strategy = Strategy::where('token', $token)->with('objective')->first();
        $deletedEvaluations = Evaluation::where('strategy_id', $strategy->id)->onlyTrashed()->get(); 

        return view('pages.ods.strategy.recover_evaluations', compact('deletedEvaluations', 'strategy'));
    }

    //RECOVER EVALUATION
    public function recover_evaluation(Request $request)
    {
        $token = $request->token;

        $evaluation = Evaluation::where('token', $token)->restore();

        return redirect()->back()->with('status', 'success')->with('message', 'Evaluacion recuperada.');
    }

    //TRUE DELETE EVALUATION
    public function true_delete_evaluation(Request $request)
    {
        $token = $request->token;

        $evaluation = Evaluation::where('token', $token)->forceDelete();

        return redirect()->back()->with('status', 'success')->with('message', 'Evaluacion eliminada permanentemente.');
    }
}
