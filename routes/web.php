<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
      Route::get('/tasks/users-by-project', [TaskController::class, 'getUsersByProject'])
        ->name('tasks.users-by-project');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::get('projects/{project}/members', [TaskController::class, 'getProjectMembers'])->name('projects.members');
    Route::get('projects/status/{status?}', [ProjectController::class, 'getProjectsByStatus'])
        ->name('projects.by-status');
    Route::resource('departments', DepartmentController::class);
    Route::patch('users/{user}/personal-info', [UserController::class, 'updatePersonalInfo'])->name('users.updatePersonalInfo');
    Route::patch('users/{user}/bank-info', [UserController::class, 'updateBankInfo'])->name('users.updateBankInfo');
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::post('/start-conversation', [MessageController::class, 'startConversation'])->name('start_conversation');
        Route::post('/create-group', [MessageController::class, 'createGroup'])->name('create_group');
        Route::post('/send', [MessageController::class, 'sendMessage'])->name('send');
        Route::get('/search', [MessageController::class, 'search'])->name('search');
        Route::get('/{conversationId}/messages', [MessageController::class, 'getMessages'])->name('get_messages');
        Route::post('/{conversationId}/add-participants', [MessageController::class, 'addParticipants'])->name('add_participants');
        Route::delete('/{conversationId}/leave', [MessageController::class, 'leaveGroup'])->name('leave_group');
    });
});
