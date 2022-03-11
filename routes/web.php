<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OdsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

//IMPERSONATE OTHER USERS
Route::impersonate();
Route::get('/impersonate/{id}', [UserController::class, 'impersonate'])->name('user.impersonate');

//CUSTOMERS
Route::prefix('customers')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::put('/create', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/edit/{token}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update', [CustomerController::class, 'update'])->name('customers.update');
});

//MODULES
Route::prefix('modules')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/create', [ModuleController::class, 'create'])->name('modules.create');
    Route::put('/create', [ModuleController::class, 'store'])->name('modules.store');
    Route::get('/edit/{token}', [ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/update', [ModuleController::class, 'update'])->name('modules.update');
});

//CUSTOMERS
Route::prefix('customers')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::put('/create', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/edit/{token}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update', [CustomerController::class, 'update'])->name('customers.update');
});

//USERS
Route::prefix('users')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::put('/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{token}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/update', [UserController::class, 'update'])->name('users.update');
});

//BRANCHES
Route::prefix('branches')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [BranchController::class, 'index'])->name('branches.index');
    Route::get('/create', [BranchController::class, 'create'])->name('branches.create');
    Route::put('/create', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/edit/{token}', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('/update', [BranchController::class, 'update'])->name('branches.update');
});

//DEPARTAMENTS
Route::prefix('departaments')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [DepartamentController::class, 'index'])->name('departaments.index');
    Route::get('/create', [DepartamentController::class, 'create'])->name('departaments.create');
    Route::put('/create', [DepartamentController::class, 'store'])->name('departaments.store');
    Route::get('/edit/{token}', [DepartamentController::class, 'edit'])->name('departaments.edit');
    Route::put('/update', [DepartamentController::class, 'update'])->name('departaments.update');
});

//PROFILE
Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'profile'])->middleware(['auth'])->name('profile');
    Route::put('/{token}', [UserController::class, 'profile_update'])->middleware(['auth'])->name('profile.update');
    Route::post('/photo/{token}', [UserController::class, 'profile_photo'])->middleware(['auth'])->name('profile.photo');
});

//ODS MODULE
Route::prefix('ods')->middleware(['auth'])->group(function () {
    Route::get('/', [OdsController::class, 'index'])->name('ods.index');
    Route::get('/objective/create', [OdsController::class, 'create'])->name('ods.objective.create');
    Route::put('/objective/store', [OdsController::class, 'store'])->name('ods.objective.store');
    Route::get('/objective/edit/{token}', [OdsController::class, 'edit'])->name('ods.objective.edit');
    Route::put('/objective/update', [OdsController::class, 'update'])->name('ods.objective.update');
    Route::get('/objective/evaluate/{token}', [OdsController::class, 'evaluate'])->name('ods.objective.evaluate');
    Route::post('/evaluate/save', [OdsController::class, 'evaluate_save'])->name('ods.objective.evaluate_save');
    Route::post('/evaluate/get_evaluations', [OdsController::class, 'get_evaluations'])->name('ods.objective.get_evaluations');
    Route::post('/evaluate/save_file', [OdsController::class, 'save_file'])->name('ods.objective.save_file');
    Route::get('/strategy/{token}', [OdsController::class, 'strategy'])->name('ods.strategy.index');
    Route::get('/strategy/{token}/create', [OdsController::class, 'strategy_create'])->name('ods.strategy.create');
    Route::put('/strategy/{token}/create', [OdsController::class, 'strategy_store'])->name('ods.strategy.store');
    Route::get('/strategy/{token_objective}/edit/{token_strategy}', [OdsController::class, 'strategy_edit'])->name('ods.strategy.edit');
    Route::put('/strategy/{token}/update', [OdsController::class, 'strategy_update'])->name('ods.strategy.update');
    Route::post('/dashboard', [OdsController::class, 'dashboard'])->name('ods.dashboard');
    Route::post('/dashboard/objective/evolution', [OdsController::class, 'objective_evolution'])->name('ods.dashboard.objective_evolution');
});

//TASKS MODULE
Route::prefix('tasks')->middleware(['auth'])->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/project/create', [TaskController::class, 'create'])->name('tasks.project.create');
    Route::put('/project/create', [TaskController::class, 'store'])->name('tasks.project.store');
    Route::get('/project/edit/{token}', [TaskController::class, 'edit'])->name('tasks.project.edit');
    Route::put('/project/update', [TaskController::class, 'update'])->name('tasks.project.update');
    Route::get('/project/{token}', [TaskController::class, 'tasks'])->name('tasks.project.details');
    Route::post('/project/get_departaments', [TaskController::class, 'get_departaments'])->name('tasks.project.get_departaments');
    Route::post('/project/add_task', [TaskController::class, 'add_task'])->name('tasks.project.add_task');
    Route::get('/project/{project}/task/{task}', [TaskController::class, 'task_details'])->name('tasks.project.task_details');
    Route::put('/project/task/comment', [TaskController::class, 'task_comment'])->name('tasks.project.task_comment');
    Route::post('/project/task/add_subtask', [TaskController::class, 'add_subtask'])->name('tasks.project.add_subtask');
    Route::post('/project/task/get_subtask', [TaskController::class, 'get_subtask'])->name('tasks.project.task.get_subtask');
    Route::post('/project/task/subtask/changeState', [TaskController::class, 'changeState'])->name('tasks.project.task.changeState');
    Route::post('/project/task/update_subtask', [TaskController::class, 'update_subtask'])->name('tasks.project.update_subtask');
    Route::post('/project/task/addFiles', [TaskController::class, 'addFiles'])->name('tasks.project.addFiles');
    Route::put('/project/task/file/update', [TaskController::class, 'updateFiles'])->name('tasks.file.update');
    
});





require __DIR__ . '/auth.php';
