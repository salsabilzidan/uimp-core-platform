<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\RoomController as ApiRoomController;
use App\Http\Controllers\Api\SubsystemController as ApiSubsystemController;

/*
|--------------------------------------------------------------------------
| API Routes - UIMP Core Platform
|--------------------------------------------------------------------------
| These routes are consumed by subsystems (e.g., Lab Management System)
| Authentication: X-API-Key header + Sanctum tokens
| Rate limiting: Named rate limiters (api, subsystems, auth)
| Scopes: subsystem.scope middleware checks subsystem permissions
|
| 📚 API Documentation: route('api.docs')
*/

// Public API endpoints (no auth required)
Route::post('/auth/token', [ApiAuthController::class, 'issueToken'])->middleware('throttle:auth');
Route::post('/subsystems/register', [ApiSubsystemController::class, 'register'])->middleware('throttle:auth');
Route::get('/health', [ApiSubsystemController::class, 'health'])->middleware('throttle:api');

// Protected API endpoints (require API Key + Sanctum token)
Route::middleware(['auth:sanctum', 'throttle:subsystems'])->group(function () {
    Route::get('/auth/verify', [ApiAuthController::class, 'verifyToken']);

    // User management for subsystems
    Route::get('/users', [ApiUserController::class, 'index'])->middleware('subsystem.scope:users.read');
    Route::get('/users/{id}', [ApiUserController::class, 'show'])->middleware('subsystem.scope:users.read');
    Route::get('/students', [ApiUserController::class, 'students'])->middleware('subsystem.scope:students.read');
    Route::get('/employees', [ApiUserController::class, 'employees'])->middleware('subsystem.scope:employees.read');

    // Building/Facility management for subsystems
    Route::get('/buildings', [ApiRoomController::class, 'buildings'])->middleware('subsystem.scope:buildings.read');

    // Room/Laboratory management for subsystems (critical for Lab Booking System)
    Route::get('/rooms', [ApiRoomController::class, 'index'])->middleware('subsystem.scope:rooms.read');
    Route::get('/rooms/{id}', [ApiRoomController::class, 'show'])->middleware('subsystem.scope:rooms.read');
    Route::get('/laboratories', [ApiRoomController::class, 'laboratories'])->middleware('subsystem.scope:laboratories.read');
});
