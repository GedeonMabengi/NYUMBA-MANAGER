<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Bailleur\DashboardController as BailleurDashboardController;
use App\Http\Controllers\Bailleur\PropertyController;
use App\Http\Controllers\Bailleur\TenantController;
use App\Http\Controllers\Bailleur\RentalController;
use App\Http\Controllers\Bailleur\AvocatController as BailleurAvocatController;
use App\Http\Controllers\Avocat\DashboardController as AvocatDashboardController;
use App\Http\Controllers\Avocat\BailleurController as AvocatBailleurController;
use App\Http\Controllers\Avocat\DocumentController as AvocatDocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
// use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Property Types
    Route::resource('property-types', PropertyTypeController::class);
    Route::post('/property-types/{propertyType}/toggle-status', [PropertyTypeController::class, 'toggleStatus'])
        ->name('property-types.toggle-status');

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');
});

/*
|--------------------------------------------------------------------------
| Bailleur Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:bailleur'])->prefix('bailleur')->name('bailleur.')->group(function () {
    Route::get('/dashboard', [BailleurDashboardController::class, 'index'])->name('dashboard');

    // Properties
    Route::resource('properties', PropertyController::class);
    Route::get('/property-types/{propertyType}/info', [PropertyController::class, 'getPropertyTypeInfo'])
        ->name('property-types.info');

    // Tenants
    Route::resource('tenants', TenantController::class);

    // Rentals
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::post('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel');
    Route::post('/rentals/{rental}/documents', [RentalController::class, 'addDocument'])->name('rentals.add-document');

    // Avocats
    Route::get('/avocats', [BailleurAvocatController::class, 'index'])->name('avocats.index');
    Route::get('/avocats/create', [BailleurAvocatController::class, 'create'])->name('avocats.create');
    Route::post('/avocats', [BailleurAvocatController::class, 'store'])->name('avocats.store');
    Route::post('/avocats/{avocat}/toggle-status', [BailleurAvocatController::class, 'toggleStatus'])
        ->name('avocats.toggle-status');
    Route::delete('/avocats/{avocat}', [BailleurAvocatController::class, 'destroy'])->name('avocats.destroy');
});

/*
|--------------------------------------------------------------------------
| Avocat Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:avocat'])->prefix('avocat')->name('avocat.')->group(function () {
    Route::get('/dashboard', [AvocatDashboardController::class, 'index'])->name('dashboard');

    // Bailleurs
    Route::get('/bailleurs', [AvocatBailleurController::class, 'index'])->name('bailleurs.index');
    Route::get('/bailleurs/{bailleur}', [AvocatBailleurController::class, 'show'])->name('bailleurs.show');
    Route::get('/bailleurs/{bailleur}/properties', [AvocatBailleurController::class, 'properties'])
        ->name('bailleurs.properties');
    Route::get('/bailleurs/{bailleur}/rentals', [AvocatBailleurController::class, 'rentals'])
        ->name('bailleurs.rentals');

    // Documents
    Route::get('/documents/{document}/download', [AvocatDocumentController::class, 'download'])
        ->name('documents.download');
    Route::get('/documents/{document}/view', [AvocatDocumentController::class, 'view'])
        ->name('documents.view');
});

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Documents (for bailleur)
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});



// routes/web.php - temporaire
Route::get('/debug-auth', function () {
    return response()->json([
        'auth_check' => auth()->check(),
        'auth_user' => auth()->user(),
        'auth_role' => auth()->user()?->role,
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
});

// routes/web.php - Ajoutez ces routes

use App\Http\Controllers\PaymentController;

// Routes pour les paiements (accessibles aux bailleurs uniquement)
Route::middleware(['auth'])->group(function () {
    Route::resource('payments', PaymentController::class);
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('payments/{payment}/print', [PaymentController::class, 'printReceipt'])->name('payments.print');
    Route::get('payments-export', [PaymentController::class, 'export'])->name('payments.export');
});