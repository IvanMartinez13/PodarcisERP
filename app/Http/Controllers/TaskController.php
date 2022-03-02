<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /*===========  PROJECTS  ==========*/

    public function index()
    {
        $customer_id = Auth::user()->customer->id;
        $projects = Project::where('customer_id', $customer_id)->get();
        return view('pages.tasks.project.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.tasks.project.create');
    }

    public function store(StoreProjectRequest $request)
    {
        //1) GET DATA
        $customer_id = Auth::user()->customer->id;

        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "color" => $request->color,
            "token" => md5($request->name . '+' . date('d/m/Y H:i:s')),
            "customer_id" => $customer_id,
        ];

        //2) STORE DATA
        if ($request->file('image')) {
            $folder = storage_path('/app/public/projects') . "/" . $customer_id;

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $file = $request->file('image');
            $ext = $file->guessExtension();
            $path = "/projects/" . $customer_id . '/' . $data["token"] . '.' . $ext;
            $data['image'] = $path;
            move_uploaded_file($file, $folder . '/' . $data["token"] . '.' . $ext); //save file
        }

        $project = new Project($data);
        $project->save();

        //3) RETURN REDIRECT
        return redirect(route('tasks.index'))->with("status", "success")->with("message", "Proyecto creado.");
    }

    public function edit($token)
    {
        $project = Project::where('token', $token)->first();
        return view('pages.tasks.project.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request)
    {
        //1) GET DATA
        $customer_id = Auth::user()->customer->id;
        $project = Project::where('token', $request->token)->first();

        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "color" => $request->color,
        ];

        //2) UPDATE DATA
        if ($request->file('image')) {

            $folder = storage_path('/app/public/projects') . "/" . $customer_id;

            if (!is_dir($folder)) {

                mkdir($folder, 0777, true);
            }

            if (!is_file(storage_path('/app/public') . $project->image)) {

                unlink(storage_path('/app/public') . $project->image);
            }

            $file = $request->file('image');
            $ext = $file->guessExtension();
            $path = "/projects/" . $customer_id . '/' . $data["token"] . '.' . $ext;
            $data['image'] = $path;
            move_uploaded_file($file, $folder . '/' . $data["token"] . '.' . $ext); //save file

        }

        $project = Project::where('token', $request->token)->update($data);

        //3) RETURN REDIRECT
        return redirect(route('tasks.index'))->with("status", "success")->with("message", "Proyecto editado.");
    }

    /*===========  END PROJECTS  ==========*/
}
