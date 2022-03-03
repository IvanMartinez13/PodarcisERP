<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /*===========  PROJECTS  ==========*/

    public function index()
    {
        $customer_id = Auth::user()->customer_id;
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
        $customer_id = Auth::user()->customer_id;

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
        $customer_id = Auth::user()->customer_id;
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
            $path = "/projects/" . $customer_id . '/' . $request->token . '.' . $ext;
            $data['image'] = $path;
            move_uploaded_file($file, $folder . '/' . $request->token . '.' . $ext); //save file

        }

        $project = Project::where('token', $request->token)->update($data);

        //3) RETURN REDIRECT
        return redirect(route('tasks.index'))->with("status", "success")->with("message", "Proyecto editado.");
    }

    /*===========  END PROJECTS  ==========*/

    public function tasks($token)
    {
        $project = Project::where('token', $token)->first();

        $tasks = Task::where('project_id', $project->id)->get();

        return view('pages.tasks.task.index', compact('project', 'tasks'));
    }

    public function get_departaments()
    {
        $branch = Branch::where('customer_id', Auth::user()->customer_id)->get();
        $branches_id = $branch->pluck('id');

        $departaments = Departament::whereHas('branches', function ($q) use ($branches_id) {
            $q->whereIn('id', $branches_id);
        })->get();

        return response()->json(["departaments" => $departaments]);
    }

    public function add_task(Request $request)
    {
        //1) GET DATA

        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "is_done" => 0,
            "token" => md5($request->name . '+' . date('d/m/Y H:i:s')),
            "project_id" => $request->project,
            "task_id" => null,
        ];

        $departaments = $request->departaments;


        //2) VALIDATE DATA

        $rules = [
            "name" => ["string", "required"],
            "description" => ["string", "required"],
            "project" => ["numeric", "required"],
            "departaments" => ["array", "required"],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "se ha producido un error."]);
        }

        //3) STORE DATA
        $task = new Task($data);
        $task->save();

        $task->departaments()->sync($departaments);

        //4) RETURN RESPONSE
        return response()->json(["status" => "success", "message" => "Tarea Creada."]);
    }

    public function task_details($token_project, $token_task)
    {
        //GET DATA
        $project = Project::where('token', $token_project)->first();
        $task = Task::where('token', $token_task)->with('departaments')->first();
        $sub_tasks = Task::where('task_id', $task->id)->get();
        //RETURN VIEW WITH DATA
        return view('pages.tasks.task.task', compact('project', 'task', 'sub_tasks'));
    }
}
