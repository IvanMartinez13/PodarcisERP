<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Models\Module;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::get();

        return view('pages.modules.index', compact('modules'));
    }

    //PAGE CREATE
    public function create()
    {
        return view('pages.modules.create');
    }

    //STORE MODULES
    public function store(StoreModuleRequest $request)
    {
        //1) GET DATA
        $data = [
            "name" => $request->name,
            "icon" => $request->icon,
            "token" => md5($request->name . "+" . date('d/m/Y H:i:s'))
        ];

        if ($data["icon"]) {
            //upload icon
            $folder = storage_path('app/public') . "/modules";

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $ext = $data["icon"]->guessExtension();

            $path = "/modules/" . $data['token'] . "." . $ext;

            move_uploaded_file($data['icon'], storage_path('app/public') . $path);

            $data['icon'] = $path;
        } else {
            unset($data['icon']);
        }

        $module = new Module($data);
        $module->save();

        return redirect(route('modules.index'))->with('message', 'Módulo creado.')->with('status', 'success');
    }

    //PAGE EDIT
    public function edit($token)
    {
        $module = Module::where('token', $token)->first();

        return view('pages.modules.edit', compact('module'));
    }

    //UPDATE MODULES
    public function update(UpdateModuleRequest $request)
    {
        //1) GET DATA
        $data = [
            "name" => $request->name,
            "icon" => $request->file('icon'),
        ];

        $module = Module::where('token', $request->token)->first();

        if ($data["icon"]) {
            //upload icon
            $folder = storage_path('app/public') . "/modules";

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            if (is_file(storage_path('app/public') . $module->icon)) {

                unlink(storage_path('app/public') . $module->icon);
            }

            $ext = $data["icon"]->guessExtension();

            $path = "/modules/" . $module->token . "." . $ext;

            move_uploaded_file($data['icon'], storage_path('app/public') . $path);

            $data['icon'] = $path;
        } else {

            unset($data['icon']);
        }

        $module = Module::where('token', $request->token)->update($data);

        return redirect(route('modules.index'))->with('message', 'Módulo editado.')->with('status', 'success');
    }
}
