<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Mail\CommentTaskMailable;
use App\Mail\SubtaskChangeMailable;
use App\Models\Branch;
use App\Models\Comment;
use App\Models\Departament;
use App\Models\Project;
use App\Models\Task;
use App\Models\Task_file;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

            if (is_file(storage_path('/app/public') . $project->image)) {

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



    public function project_delete(Request $request)
    {
        $project = Project::where('token', $request->token)->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Projecto eliminado.');
    }

    /*===========  END PROJECTS  ==========*/

    public function tasks($token)
    {
        $project = Project::where('token', $token)->first();

        $tasks = Task::where('project_id', $project->id)->where('task_id', null)->with('departaments')->get();

        foreach ($tasks as $key => $task) {

            $subtasks = Task::where('task_id', $task->id)->get();

            $done = 0;

            foreach ($subtasks as $sub_task) {
                if ($sub_task->is_done == 1) {
                    $done += 1;
                }
            }

            if (count($subtasks) > 0) {
                $progress = ($done / count($subtasks)) * 100;
            } else {
                $progress = 0;
            }

            $tasks[$key]['progress'] = $progress;
        }



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
        $departaments = Departament::whereIn('token', $departaments)->get('id');

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

    public function update_task(Request $request)
    {

        //1) GET DATA
        $task = Task::where('token', $request->token)->first();

        $data = [
            "name" => $request->name,
            "description" => $request->description,
        ];

        $departaments = $request->departaments;
        $departaments = Departament::whereIn('token', $departaments)->get('id');

        $task = Task::where('token', $request->token)->update($data);
        $task = Task::where('token', $request->token)->first();

        $task->departaments()->sync($departaments);

        return response()->json(["status" => "success", "message" => "Tarea Editada."]);
    }

    public function delete_task(Request $request)
    {
        $task = Task::where('token', $request->token)->delete();

        return response()->json(["status" => "success", "message" => "Tarea Eliminada."]);
    }

    public function delete_subtask(Request $request)
    {


        $subtask = Task::where('token', $request->token)->delete();



        return response()->json(["status" => "success", "message" => "Subtarea Eliminada."]);
    }



    public function task_details($token_project, $token_task)
    {
        //GET DATA
        $project = Project::where('token', $token_project)->first();
        $task = Task::where('token', $token_task)->with('departaments')->first();
        $sub_tasks = Task::where('task_id', $task->id)->get();
        $comments = Comment::where('task_id', $task->id)->with('user')->orderBy('created_at', 'DESC')->get();
        $tasks_files = Task_file::where('task_id', $task->id)->get();

        $done = 0;

        foreach ($sub_tasks as $key => $sub_task) {
            if ($sub_task->is_done == 1) {
                $done += 1;
            }
        }
        if (count($sub_tasks) > 0) {
            $progress = ($done / count($sub_tasks)) * 100;
        } else {

            if ($task->is_done) {
                $progress = 100;
            } else {
                $progress = 0;
            }
        }


        //RETURN VIEW WITH DATA
        return view('pages.tasks.task.task', compact('project', 'task', 'sub_tasks', 'comments', 'progress', 'tasks_files'));
    }

    public function task_comment(Request $request)
    {
        //1) GET DATA
        $task = Task::where('token', $request->token)->with('departaments')->first();
        $project = Project::where('id', $task->project_id)->first();


        $data = [
            "comment" => $request->comment,
            "user_id" => Auth::user()->id,
            "task_id" => $task->id,
            "token" => md5($request->comment . '+' . date('d/m/Y H:i:s'))
        ];

        //2) VERIFY DATA
        $rules = [
            "comment" => ["string", "required", 'max:255'],
            "token" => ["string", "required"],
        ];

        $attributes = [
            "comment" => "Comentario",
            "token" => "Token",
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //3) STORE DATA
        $comment = new Comment($data);
        $comment->save();

        //SEND MAIL
        $mail = new CommentTaskMailable($task, $project,  Auth::user(), $comment);

        $departamentsId = [$task->departaments->pluck('id')];
        $departaments = Departament::whereIn('id', $departamentsId)->with('users')->get();
        $emails =  [];

        foreach ($departaments as $departament) {
            $users = $departament->users;

            $users = $users->pluck('email');
            foreach ($users as $user_email) {
                if (!array_search($user_email, $emails)) {

                    array_push($emails, $user_email);
                }
            }
        }

        foreach ($emails as $key => $email) {

            if ($email != Auth::user()->email) {
                Mail::to($email)->send($mail);
            }
        }

        //4) RETURN REDIRECT
        return redirect()->back()->with('status', 'success')->with('message', 'Tarea comentada.');
    }

    public function add_subtask(Request $request)
    {
        //1) GET DATA
        $task = Task::where('token', $request->task)->with('departaments')->first();

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'is_done' => 0,
            'token' => md5($request->name . '+' . date('d/m/Y H:i:s')),
            'project_id' => $task->project_id,
            'task_id' => $task->id,
        ];

        $departaments = $task->departaments->pluck('id');

        //2) VALIDATE DATA
        $rules = [
            "name" => ["string", "required"],
            "description" => ["string", "required"],
            "task" => ["string", "required"],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "se ha producido un error."]);
        }

        //3) STORE DATA
        $subtask = new Task($data);
        $subtask->save();

        $subtask->departaments()->sync($departaments);


        $subtasks = Task::where('task_id', $task->id)->get();

        $done = 0;

        foreach ($subtasks as $key => $sub_task) {
            if ($sub_task->is_done == 1) {
                $done += 1;
            }
        }
        if (count($subtasks) > 0) {
            $progress = ($done / count($subtasks)) * 100;
        } else {
            $progress = 0;
        }

        //4) RETURN RESPONSE
        return response()->json(["status" => "success", "message" => "Subtarea Creada.", "progress" => $progress]);
    }

    public function get_subtask(Request $request)
    {
        $task = Task::where('token', $request->task)->first();
        $subtasks = Task::where('task_id', $task->id)->get();

        $response = [
            "subtasks" => $subtasks,
        ];

        return response()->json($response);
    }

    public function changeState(Request $request)
    {
        if ($request->value) {

            $task = Task::where('token', $request->task)->update(['is_done' => 1]);
            $task = Task::where('token', $request->task)->first();

            $parent_task = Task::where('id', $task->task_id)->first();

            $subtasks = Task::where('task_id', $parent_task->id)->get();

            $project = Project::where('id', $parent_task->project_id)->first();

            $done = 0;

            foreach ($subtasks as $key => $sub_task) {
                if ($sub_task->is_done == 1) {
                    $done += 1;
                }
            }
            if (count($subtasks) > 0) {
                $progress = ($done / count($subtasks)) * 100;
            } else {
                $progress = 0;
            }

            $mail = new SubtaskChangeMailable($parent_task, $project,  Auth::user(), $task, false);

            $departamentsId = [$task->departaments->pluck('id')];
            $departaments = Departament::whereIn('id', $departamentsId)->with('users')->get();
            $emails =  [];

            foreach ($departaments as $departament) {
                $users = $departament->users;

                $users = $users->pluck('email');
                foreach ($users as $user_email) {
                    if (!array_search($user_email, $emails)) {

                        array_push($emails, $user_email);
                    }
                }
            }

            foreach ($emails as $key => $email) {

                if ($email != Auth::user()->email) {
                    Mail::to($email)->send($mail);
                }
            }


            return response()->json(["status" => "status", "message" => "Se finalizado una tarea.", "progress" => $progress]);
        } else {
            $task = Task::where('token', $request->task)->update(['is_done' => 0]);

            $task = Task::where('token', $request->task)->first();

            $parent_task = Task::where('id', $task->task_id)->first();

            $subtasks = Task::where('task_id', $parent_task->id)->get();

            $project = Project::where('id', $parent_task->project_id)->first();

            $done = 0;

            foreach ($subtasks as $key => $sub_task) {
                if ($sub_task->is_done == 1) {
                    $done += 1;
                }
            }

            if (count($subtasks) > 0) {
                $progress = ($done / count($subtasks)) * 100;
            } else {
                $progress = 0;
            }

            $mail = new SubtaskChangeMailable($parent_task, $project,  Auth::user(), $task, true);

            $departamentsId = [$task->departaments->pluck('id')];
            $departaments = Departament::whereIn('id', $departamentsId)->with('users')->get();
            $emails =  [];

            foreach ($departaments as $departament) {
                $users = $departament->users;

                $users = $users->pluck('email');
                foreach ($users as $user_email) {
                    if (!array_search($user_email, $emails)) {

                        array_push($emails, $user_email);
                    }
                }
            }

            foreach ($emails as $key => $email) {

                if ($email != Auth::user()->email) {
                    Mail::to($email)->send($mail);
                }
            }

            return response()->json(["status" => "error", "message" => "Se ha abierto una tarea.", "progress" => $progress]);
        }
    }

    public function update_subtask(Request $request)
    {


        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        //2) VALIDATE DATA
        $rules = [
            "name" => ["string", "required"],
            "description" => ["string", "required"],
            "task" => ["string", "required"],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "se ha producido un error."]);
        }

        $task = Task::where('token', $request->task)->update($data);

        return response()->json(["status" => "success", "message" => "Subtarea Editada."]);
    }

    public function addFiles(Request $request)
    {
        //1) GET DATA
        $customer_id = Auth::user()->customer_id;
        $task = Task::where('token', $request->token)->first();
        $files = $request->file('file');
        $task_files = [];

        foreach ($files as $file) {

            $filename = $file->getClientOriginalName();

            $folder = '/projects/' . $customer_id . '/' . $task->project_id;

            $token = md5($filename . '+' . date('d/m/Y H:i:s'));

            $ext = '.' . $file->guessExtension();

            if (!is_dir(storage_path('app/public') . $folder)) {

                mkdir(storage_path('app/public') . $folder, 0777, true); //CREATE FOLDER
            }

            $data = [
                "name" => $filename,
                "task_id" => $task->id,
                "token" => $token,
                "path" => $folder . '/' . $token . $ext
            ];

            //2) STORE DATA
            move_uploaded_file($file, storage_path('app/public') . $data['path']); //STORE FILE
            $task_file = new Task_file($data);
            $task_file->save();
            array_push($task_files, $task_file);
        }

        return response()->json(['status' => 'success', 'message' => 'Documentos guardados.', 'task_files' => $task_files]);
    }

    public function updateFiles(Request $request)
    {
        //1) GET DATA
        $token = $request->token;
        $task_file = Task_file::where('token', $token)->first();
        $task = Task::where('id', $task_file->task_id)->first();
        $customer_id = Auth::user()->customer_id;

        $data = ['name' => $request->name];

        //2) VALIDATE DATA
        $rules = [
            'name' => ['string', 'required', 'max:255'],
            'token' => ['string', 'required', 'max:255'],
            'file' => ['file', 'nullable']
        ];

        $attributes = [
            'name' => 'Nombre',
            'token' => 'Token',
            'file' => 'Documento'
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //3) UPDATE DATA
        $file = $request->file('file');

        if ($file != null) {
            //change file
            $folder = '/projects/' . $customer_id . '/' . $task->project_id;

            if (!is_dir(storage_path('app/public') . $folder)) {

                mkdir(storage_path('app/public') . $folder, 0777, true); //CREATE FOLDER
            }

            $ext = '.' . $file->guessExtension();

            $data["path"] = $folder . '/' . $token . $ext;

            if (is_file(storage_path('app/public') . $task_file->path)) {
                unlink(storage_path('app/public') . $task_file->path);
            }

            move_uploaded_file($file, storage_path('app/public') . $data['path']); //STORE FILE
        }

        $task_file = Task_file::where('token', $token)->update($data);

        //4) RETURN REDIRECT
        return redirect()->back()->with('status', 'success')->with('message', 'Documento editado.');
    }

    public function changeState_task(Request $request)
    {
        $task = Task::where('token', $request->token)->first();

        if ($task->is_done == 0) {
            $task = Task::where('token', $request->token)->update(['is_done' => 1]);
            $task = Task::where('token', $request->token)->first();

            $sub_tasks = Task::where('task_id', $task->id)->get();

            $done = 0;

            foreach ($sub_tasks as $key => $sub_task) {
                if ($sub_task->is_done == 1) {
                    $done += 1;
                }
            }
            if (count($sub_tasks) > 0) {
                $progress = ($done / count($sub_tasks)) * 100;
            } else {

                if ($task->is_done) {
                    $progress = 100;
                } else {
                    $progress = 0;
                }
            }

            $response = [
                'status' => 'success',
                'message' => 'Se ha finalizado una tarea.',
                'close' => 1,
                'progress' =>  $progress
            ];
        } else {
            $task = Task::where('token', $request->token)->update(['is_done' => 0]);

            $task = Task::where('token', $request->token)->first();

            $sub_tasks = Task::where('task_id', $task->id)->get();

            $done = 0;

            foreach ($sub_tasks as $key => $sub_task) {
                if ($sub_task->is_done == 1) {
                    $done += 1;
                }
            }
            if (count($sub_tasks) > 0) {
                $progress = ($done / count($sub_tasks)) * 100;
            } else {

                if ($task->is_done) {
                    $progress = 100;
                } else {
                    $progress = 0;
                }
            }

            $response = [
                'status' => 'success',
                'message' => 'Se ha abierto una tarea.',
                'close' => 0,
                'progress' =>  $progress
            ];
        }



        return response()->json($response);
    }


    public function file_delete(Request $request)
    {
        $file = Task_file::where('token', $request->token)->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Archivo eliminado.');
    }
}
