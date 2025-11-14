<?php

use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [HomeController::class, 'createLogin'])->name('login');
Route::post('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'createRegister'])->name('register');
Route::post('register', [HomeController::class, 'register'])->name('register');
Route::post('logout', [HomeController::class, 'destroy'])
        ->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('dashboard', [TicketController::class, 'dashboard'])->name('user.dashboard');
    
    // Subscription Routes
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('subscriptions/{id}/purchase', [SubscriptionController::class, 'purchase'])->name('subscriptions.purchase');
    Route::post('subscriptions/{id}/payment', [SubscriptionController::class, 'processPayment'])->name('subscriptions.payment');
    Route::get('my-subscription', [SubscriptionController::class, 'mySubscription'])->name('subscriptions.my');
    
    // Payment Routes
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
    
    // Chat Routes (Protected by subscription)
    Route::middleware('check_subscription')->group(function () {
        Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('chat', [ChatController::class, 'store'])->name('chat.store');
        Route::get('chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    });
});

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
    
    // Admin Home Page Management
    Route::resource('admin/homepage', HomePageController::class)->names([
        'index' => 'admin.homepage.index',
        'create' => 'admin.homepage.create',
        'store' => 'admin.homepage.store',
        'edit' => 'admin.homepage.edit',
        'update' => 'admin.homepage.update',
        'destroy' => 'admin.homepage.destroy',
    ]);
    
    // Admin Subscription Plans Management
    Route::resource('admin/subscriptions', SubscriptionPlanController::class)->names([
        'index' => 'admin.subscriptions.index',
        'create' => 'admin.subscriptions.create',
        'store' => 'admin.subscriptions.store',
        'edit' => 'admin.subscriptions.edit',
        'update' => 'admin.subscriptions.update',
        'destroy' => 'admin.subscriptions.destroy',
    ]);

    // Admin Categories Management
    Route::resource('admin/categories', CategoryController::class)->except(['show'])->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Admin Departments Management
    Route::resource('admin/departments', DepartmentController::class)->except(['show'])->names([
        'index' => 'admin.departments.index',
        'create' => 'admin.departments.create',
        'store' => 'admin.departments.store',
        'edit' => 'admin.departments.edit',
        'update' => 'admin.departments.update',
        'destroy' => 'admin.departments.destroy',
    ]);
    
    // Admin Chat Management (No auth middleware needed as it's already in the group)
    Route::get('admin/chat', [ChatController::class, 'index'])->name('admin.chat.index');
    Route::get('admin/chat/{userId}', [ChatController::class, 'show'])->name('admin.chat.show');
    Route::post('admin/chat', [ChatController::class, 'store'])->name('admin.chat.store');

});
