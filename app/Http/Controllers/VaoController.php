<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayerGroup;
use App\Http\Requests\StoreVaoRequest;
use App\Http\Requests\UpdateVaoRequest;
use App\Models\Layer_group;
use App\Models\Vao;
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
            'token' => md5( $request->title.'+'.date('d/m/Y H:i:s') )
        ];

        $file = $request->file('image');

        //2) STORE DATA

        //STORE FILE

        if ($file) {
            
            //check if we need to create a folder
            $folder = '/vao/'.$customer_id.'/'.$data['token'];

            if ( !is_dir(storage_path('/app/public') . $folder ) ) {
                
                mkdir(storage_path('/app/public') . $folder, 0777, true); //create folder
            }

            $extension = '.'.$file->guessExtension();
            $filename = $file->getClientOriginalName();
            $filename = md5( $filename .'+'.date('d/m/Y H:i:s') ).$extension;
            $path = $folder.'/'.$filename;

            $data['image'] = $path;

            move_uploaded_file( $file, storage_path('/app/public').$path ) ; //upload file to path

        }

        //STORE VAO

        $vao = new Vao($data);
        $vao->save();

        //3) RETURN VIEW
        return redirect( route('vao.index') )->with('status', 'success')->with('message', 'Vigilancia ambiental creada');
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
            $folder = '/vao/'.$customer_id.'/'.$data['token'];

            if ( !is_dir(storage_path('/app/public') . $folder ) ) {
                
                mkdir(storage_path('/app/public') . $folder, 0777, true); //create folder
            }

            if ( is_file(storage_path('/app/public') . $vao->image ) ) {
                
                unlink(storage_path('/app/public') . $vao->image); //delete file
            }

            $extension = '.'.$file->guessExtension();
            $filename = $file->getClientOriginalName();
            $filename = md5( $filename .'+'.date('d/m/Y H:i:s') ).$extension;
            $path = $folder.'/'.$filename;

            $data['image'] = $path;

            move_uploaded_file( $file, storage_path('/app/public').$path ) ; //upload file to path

        }

        $vao = Vao::where('token', $request->token)->update($data);

        //3) RETURN VIEW
        return redirect( route('vao.index') )->with('status', 'success')->with('message', 'Vigilancia ambiental editada.');
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
            'token' => md5( $request->name.'+'.date('d/m/Y H:i:s') )
        ];

        $layer_group = new Layer_group($data);
        $layer_group->save();

        return response()->json(['status' => 'success', 'message' => 'Grupo de layers guardado.']);
    
    }
    
}
