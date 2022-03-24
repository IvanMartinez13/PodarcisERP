<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayerGroup;
use App\Http\Requests\StoreVaoRequest;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateLayerRequest;
use App\Http\Requests\UpdateVaoRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Models\Layer;
use App\Models\Layer_group;
use App\Models\User;
use App\Models\Vao;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaoController extends Controller
{
    public function index()
    {
        $customer_id = Auth::user()->customer_id;

        $vaos = Vao::where('customer_id', $customer_id)->get();
        return view('pages.vao.index', compact('vaos'));
    }

    //PAGE CREATE
    public function create()
    {
        return view('pages.vao.create');
    }

    //PAGE STORE VAO TO BBDD
    public function store(StoreVaoRequest $request)
    {
        //1) GET DATA
        $customer_id = Auth::user()->customer_id;

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'code' => $request->code,
            'state' => $request->state,
            'location' => $request->location,
            'direction' => $request->direction,
            'customer_id' => $customer_id,
            'token' => md5($request->title . '+' . date('d/m/Y H:i:s'))
        ];

        $file = $request->file('image');

        //2) STORE DATA

        //STORE FILE

        if ($file) {

            //check if we need to create a folder
            $folder = '/vao/' . $customer_id . '/' . $data['token'];

            if (!is_dir(storage_path('/app/public') . $folder)) {

                mkdir(storage_path('/app/public') . $folder, 0777, true); //create folder
            }

            $extension = '.' . $file->guessExtension();
            $filename = $file->getClientOriginalName();
            $filename = md5($filename . '+' . date('d/m/Y H:i:s')) . $extension;
            $path = $folder . '/' . $filename;

            $data['image'] = $path;

            move_uploaded_file($file, storage_path('/app/public') . $path); //upload file to path

        }

        //STORE VAO

        $vao = new Vao($data);
        $vao->save();

        //3) RETURN VIEW
        return redirect(route('vao.index'))->with('status', 'success')->with('message', 'Vigilancia ambiental creada');
    }

    //PAGE EDIT
    public function edit($token)
    {
        $vao = Vao::where('token', $token)->first();
        return view('pages.vao.edit', compact('vao'));
    }

    public function update(UpdateVaoRequest $request)
    {
        // 1) GET DATA
        $vao = Vao::where('token', $request->token)->first();
        $customer_id = Auth::user()->customer_id;

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'code' => $request->code,
            'state' => $request->state,
            'location' => $request->location,
            'direction' => $request->direction,
        ];

        $file = $request->file('image');

        // 2) UPDATE DATA

        if ($file) {

            //check if we need to create a folder
            $folder = '/vao/' . $customer_id . '/' . $data['token'];

            if (!is_dir(storage_path('/app/public') . $folder)) {

                mkdir(storage_path('/app/public') . $folder, 0777, true); //create folder
            }

            if (is_file(storage_path('/app/public') . $vao->image)) {

                unlink(storage_path('/app/public') . $vao->image); //delete file
            }

            $extension = '.' . $file->guessExtension();
            $filename = $file->getClientOriginalName();
            $filename = md5($filename . '+' . date('d/m/Y H:i:s')) . $extension;
            $path = $folder . '/' . $filename;

            $data['image'] = $path;

            move_uploaded_file($file, storage_path('/app/public') . $path); //upload file to path

        }

        $vao = Vao::where('token', $request->token)->update($data);

        //3) RETURN VIEW
        return redirect(route('vao.index'))->with('status', 'success')->with('message', 'Vigilancia ambiental editada.');
    }

    //VAO DETAILS
    public function details($token)
    {
        $vao = Vao::where('token', $token)->first();

        return view('pages.vao.details', compact('vao'));
    }


    /* LAYER GROUP FOR THIS VAO */

    public function create_layer_group(StoreLayerGroup $request)
    {
        $vao = Vao::where('token', $request->token)->first();

        $data = [
            'name' => $request->name,
            'vao_id' => $vao->id,
            'token' => md5($request->name . '+' . date('d/m/Y H:i:s'))
        ];

        $layer_group = new Layer_group($data);
        $layer_group->save();

        return response()->json(['status' => 'success', 'message' => 'Grupo de layers guardado.']);
    }

    public function addlayer_index(Request $request)
    {
        $vao = Vao::where('token', $request->token)->first();

        $layer_groups = Layer_group::where('vao_id', $vao->id)->get();

        $response = ['layer_groups' => $layer_groups];

        return response()->json($response);
    }

    public function addLayer(Request $request)
    {

        //1) GET DATA
        $user = Auth::user();
        $vao = Vao::where('token', $request->token)->first();
        $layer_group = Layer_group::where('token', $request->group)->first();

        if ($layer_group != null) {
            $data = [
                "name" => $request->name,
                "type" => $request->type,
                "layer_group_id" => $layer_group->id,
                "vao_id" => $vao->id,
                "token" => md5($request->name . '+' . date('d/m/Y H:i:s'))
            ];
        } else {

            $data = [
                "name" => $request->name,
                "type" => $request->type,
                "layer_group_id" => null,
                "vao_id" => $vao->id,
                "token" => md5($request->name . '+' . date('d/m/Y H:i:s'))
            ];
        }

        $file = $request->file;

        //2) STORE DATA

        //CREATE FOLDER
        $folder = '/vao/' . $user->customer_id . '/' . $vao->token . '/layers';

        if (!is_dir(storage_path('/app/public') . $folder)) {

            mkdir(storage_path('/app/public') . $folder, 0777, true);
        }

        //STORE FILE
        $ext = "." . $file->guessExtension();


        if ($data['type'] == 'kml') {
            # code...

            if ($ext == '.xml') {

                $ext = '.kml';
            } else {
                $ext = '.kmz';
            }
        }



        $path = $folder . '/' . $data['token'] . $ext;


        move_uploaded_file($file,  storage_path('/app/public') . $path); //upload file

        $data['path'] = $path;


        //STORE LAYER ON BBDD

        $layer = new Layer($data);

        $layer->save();

        //3) RETURN RESPONSE
        $response = ['status' => 'success', 'message' => 'Layer guardado.'];
        return response()->json($response);
    }

    public function get_layers(Request $request)
    {
        $vao = Vao::where('token', $request->token)->first();

        //$layer_group = Layer_group::where('vao_id', $vao->id)->get(); LUEGO FILTRAMOS POR GRUPOS

        $layers = Layer::where('vao_id', $vao->id)->with('group')->get();

        $response = ['layers' => $layers];

        return response()->json($response);
    }

    public function layer_edit($vao_token, $layer_token)
    {
        $vao = Vao::where('token', $vao_token)->first();

        $layer = Layer::where('token', $layer_token)->with('group')->first();

        $layer_groups = Layer_group::where('vao_id', $vao->id)->get();

        return view('pages.vao.layers.edit', compact('vao', 'layer', 'layer_groups'));
    }

    public function layer_update(UpdateLayerRequest $request)
    {
        //1) GET DATA
        $user = Auth::user();
        $layer_group = Layer_group::where('token', $request->group)->first();
        $layer = Layer::where('token', $request->token)->with('group')->first();
        $vao = Vao::where('id', $layer->vao_id)->first();

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'layer_group_id' => $layer_group->id,
        ];

        $file = $request->file('file');

        //2) UPDATE DATA

        if ($file != null) {
            $folder = '/vao/' . $user->customer_id . '/' . $vao->token . '/layers';

            if (!is_dir(storage_path('/app/public') . $folder)) {

                mkdir(storage_path('/app/public') . $folder, 0777, true);
            }

            if (is_file(storage_path('/app/public') . $layer->path)) {
                unlink(storage_path('/app/public') . $layer->path);
            }

            //STORE FILE
            $ext = "." . $file->guessExtension();


            if ($data['type'] == 'kml') {
                # code...

                if ($ext == '.xml') {

                    $ext = '.kml';
                } else {
                    $ext = '.kmz';
                }
            }



            $path = $folder . '/' . $layer->token . $ext;


            move_uploaded_file($file,  storage_path('/app/public') . $path); //upload file

            $data['path'] = $path;
        }

        $layer = Layer::where('token', $request->token);
        $layer->update($data);

        //3) RETURN RESPONSE

        return redirect(route('vao.details', $vao->token))->with('status', 'success')->with('message', 'Archivo editado.');
    }

    public function delete_layer(Request $request)
    {
        $token = $request->token;

        $layer = Layer::where('token', $token)->delete();

        return response()->json(['status' => 'success', 'message' => 'Archivo eliminado.']);
    }

    public function create_visit($token)
    {
        $vao = Vao::where('token', $token)->first();
        $customer_id = Auth::user()->customer_id;
        $users = User::where('customer_id', $customer_id)->get();

        return view('pages.vao.visits.create', compact('vao', 'users'));
    }

    public function store_visit(StoreVisitRequest $request)
    {
        //1) GET DATA
        $vao = Vao::where('token', $request->token)->first();
        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "starts_at" => $request->starts_at,
            "ends_at" => $request->ends_at,
            "color" => $request->color,
            "token" => md5($request->name . '+' . date('d/m/Y H:s:i')),
            "compilance" => 0,
            "vao_id" => $vao->id,
        ];
        $users = $request->users;

        $users = User::whereIn('token', $users)->get('id');

        //2) STORE DATA

        $visit = new Visit($data);
        $visit->save();

        $visit->users()->sync($users);

        //3) RETURN REDIRECT
        return redirect(route('vao.details', $vao->token))->with('status', 'success')->with('message', 'Visita creada.');
    }

    public function get_visits(Request $request)
    {
        $token = $request->token;

        $vao = Vao::where('token', $token)->first();
        $visits = Visit::where('vao_id', $vao->id)->get();

        return response()->json(['visits' => $visits]);
    }

    public function edit_visit($token)
    {
        $visit = Visit::where('token', $token)->with('users')->first();
        $vao = Vao::where('id', $visit->vao_id)->first();
        $customer_id = Auth::user()->customer_id;
        $users = User::where('customer_id', $customer_id)->get();

        return view('pages.vao.visits.edit', compact('vao', 'visit', 'users'));
    }

    public function update_visit(UpdateVisitRequest $request)
    {
        //1) GET DATA
        $visit = Visit::where('token', $request->token)->with('users')->first();
        $vao = Vao::where('id', $visit->vao_id)->first();

        $data = [
            "name" => $request->name,
            "color" => $request->color,
            "starts_at" => $request->starts_at,
            "ends_at" => $request->ends_at,
            "description" => $request->description,
        ];

        $users = $request->users;
        $users = User::whereIn('token', $users)->get('id');
        //2) UPDATE DATA

        $visit = Visit::where('token', $request->token)->update($data);
        $visit = Visit::where('token', $request->token)->with('users')->first();
        $visit->users()->sync($users);

        //3) RETURN REDIRECT
        return redirect(route('vao.details', $vao->token))->with('status', 'success')->with('message', 'Visita editada.');
    }

    public function delete_visit(Request $request)
    {
        $visit = Visit::where('token', $request->token)->delete();

        return response()->json(['status' => 'success', 'message' => 'Visita eliminada']);
    }
}
