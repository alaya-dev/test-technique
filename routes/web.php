<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect('/login'); // Rediriger vers la page de connexion
});

Route::middleware(['auth', 'leader', 'verified'])->group(function () {
 
    //Gestion des membres

    Route::get('/ajout-user', function () {
        return view('ajout-user');
    })->name('ajout-user');
    Route::post('/ajoutuser', [UserManagementController::class, 'addUser']);

    Route::get('/liste-user', [UserManagementController::class, 'getUser']);
        
    Route::get('/modifier-user/{id}', [UserManagementController::class, 'getUserId']);
    
    Route::post('/ModifyUser', [UserManagementController::class, 'UpdateUser']);
    
    Route::get('/SuppUser/{id}', [UserManagementController::class, 'SuppUser']);

    //Gestion des taches
    Route::get('/ajout-task', function () {
        return view('ajout-task');
    })->name('ajout-task');
    Route::post('/ajouttask', [TaskController::class, 'addTask']);

    Route::get('/liste-task', [TaskController::class, 'getTask']);

    Route::get('/ajout-task', [TaskController::class, 'showAddTaskForm']);

    
        
    Route::get('/modifier-task/{id}', [TaskController::class, 'getTaskId']);
    
    Route::post('/ModifyTask', [TaskController::class, 'UpdateTask']);
    
    Route::get('/SuppTask/{id}', [TaskController::class, 'SuppTask']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/home', [TaskController::class, 'getTaskMember']);




    Route::post('/update-status/{id}', [TaskController::class, 'updateStatus'])->name('update.status');

    

})->middleware(['auth', 'verified'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
