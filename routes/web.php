<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProposesController;
use App\Http\Controllers\SalaryslipController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('timesheets', TimesheetController::class);
    Route::resource('salaryslips', SalaryslipController::class);
    Route::resource('vendors', VendorController::class);
     Route::resource('item-categories', ItemCategoryController::class);
       Route::resource('proposes', ProposesController::class);

    // Additional propose actions
    Route::prefix('proposes')->name('proposes.')->group(function () {

        // Submit propose for review
        Route::patch('{propose}/submit', [ProposesController::class, 'submit'])
            ->name('submit');

        // Review propose (for reviewers)
        Route::patch('{propose}/review', [ProposesController::class, 'review'])
            ->name('review')
            ->middleware('can:review,propose');

        // Approve/reject propose (for approvers)
        Route::patch('{propose}/approve', [ProposesController::class, 'approve'])
            ->name('approve')
            ->middleware('can:approve,propose');

        // Cancel propose
        Route::patch('{propose}/cancel', [ProposesController::class, 'cancel'])
            ->name('cancel')
            ->middleware('can:update,propose');

        // Statistics for dashboard
        Route::get('statistics', [ProposesController::class, 'statistics'])
            ->name('statistics');

        // Export proposes
        Route::get('export', [ProposesController::class, 'export'])
            ->name('export')
            ->middleware('can:export-proposes');

        // Download attachment
        Route::get('{propose}/attachments/{index}', [ProposesController::class, 'downloadAttachment'])
            ->name('download-attachment')
            ->middleware('can:view,propose');
    });
    Route::get('proposes/{propose}/download-attachment/{index}', [ProposesController::class, 'downloadAttachment'])->name('proposes.download-attachment');
    Route::patch('item-categories/{itemCategory}/toggle-active', [ItemCategoryController::class, 'toggleActive'])
         ->name('item-categories.toggle-active');
  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])->name('notifications.unread');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/load-more', [NotificationController::class, 'loadMore'])->name('notifications.load-more');
    // Additional routes
    Route::patch('salaryslips/{salaryslip}/status', [SalaryslipController::class, 'updateStatus'])
         ->name('salaryslips.updateStatus');

    Route::get('salaryslips/{salaryslip}/print', [SalaryslipController::class, 'print'])
         ->name('salaryslips.print');
    Route::post('timesheets/{timesheet}/submit', [TimesheetController::class, 'submit'])->name('timesheets.submit');
    Route::get('/leaders', [UserController::class, 'leader'])->name('users.leaders');
    Route::get('/users/leaders/{id}/staff-and-project', [UserController::class, 'getStaffAndProject'])
        ->name('users.leaders.staff-and-project');
    Route::post('timesheets/{timesheet}/approve', [TimesheetController::class, 'approve'])->name('timesheets.approve');
    Route::post('timesheets/{timesheet}/reject', [TimesheetController::class, 'reject'])->name('timesheets.reject');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('projects/{project}/members', [TaskController::class, 'getProjectMembers'])->name('projects.members');
    Route::get('department/users', [TaskController::class, 'getDepartmentUsers'])->name('department.users');
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
