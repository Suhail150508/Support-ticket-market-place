<?php

use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [HomeController::class, 'index']);

Route::get('login', [HomeController::class, 'createLogin'])->name('login');
Route::post('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'createRegister'])->name('register');
Route::post('register', [HomeController::class, 'register'])->name('register');
Route::post('logout', [HomeController::class, 'destroy'])
        ->name('logout');


Route::resource('tickets', TicketController::class);
Route::post('tickets/{ticket}/reply', [TicketReplyController::class, 'store'])->name('tickets.reply');
Route::post('tickets/{ticket}/status', [TicketController::class, 'changeStatus'])->name('tickets.status');


Route::middleware(['auth','is_admin'])->group(function () {
  Route::get('admin/dashboard', [TicketController::class, 'adminIndex'])->name('admin.dashboard');
  
    Route::get('admin/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('admin/tickets/create', [AdminTicketController::class, 'create'])->name('admin.tickets.create');
    Route::post('admin/tickets', [AdminTicketController::class, 'store'])->name('admin.tickets.store');
    Route::get('admin/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::get('admin/tickets/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('admin/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('admin/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('admin.tickets.destroy');
    
    // Admin User Management
    Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');

});