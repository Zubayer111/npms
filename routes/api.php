<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Middleware\ResetPassTokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



    Route::prefix('dashboard')->middleware([TokenVerificationMiddleware::class])->group(function () {
        Route::get('home', [DashboardController::class, 'index']);
        Route::get('profile', [DashboardController::class, 'profilePage']);
        Route::get('profile-edit', [DashboardController::class, 'profileEditPage']);
        Route::get('logout-user', [UserController::class, 'userLogOut']);
        Route::post('create-user', [UserController::class, 'createUser']);
        Route::get('show-user', [UserController::class, 'showUser']);
        Route::post('user-delete', [UserController::class, 'userDelete']);
        Route::get('show-user-list', [UserController::class, 'sowAllUsers']);
        Route::get('edit-user/{id}', [UserController::class, 'editUser']);
        Route::post('update-user', [UserController::class, 'updateUser']);

        // admin routes
        Route::prefix('admin')->group(function () {
            Route::get('user-list', [AdminController::class, 'userListPage']);
            Route::get('create-user', [AdminController::class, 'createUserPage']);
            Route::post('profile-create', [AdminController::class, 'profileCreate']);
            Route::get('profile-read', [AdminController::class, 'profileRead']);
            Route::get('profile-edit', [AdminController::class, 'profileEdit']);
            Route::get('profile-delete/{id}', [AdminController::class, 'profileDelete']);
        });

        // doctor routes
        Route::prefix('doctor')->group(function () {
            Route::post('profile-create', [DoctorController::class, 'profileCreate']);
            Route::get('profile-read', [DoctorController::class, 'profileRead']);
            Route::get('profile-edit', [DoctorController::class, 'profileEdit']);
            Route::get('profile-delete/{id}', [DoctorController::class, 'profileDelete']);
        });

        // patient routes
        Route::prefix('patient')->group(function () {
            Route::post('profile-create', [PatientController::class, 'profileCreate']);
            Route::get('profile-read', [PatientController::class, 'profileRead']);
            Route::get('profile-edit', [PatientController::class, 'profileEdit']);
            Route::get('profile-delete/{id}', [PatientController::class, 'profileDelete']);
        });
    });

    // user routes outside the dashboard
    Route::get('login', [UserController::class, 'userLoginPage']);
    Route::get('send-otp', [UserController::class, 'SendOtpPage']);
    Route::post('send-otp', [UserController::class, 'sendOtp'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::get('verify-otp', [UserController::class, 'VerifyOTPPage'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::post('verify-otp', [UserController::class, 'VerifyOTP'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::get('reset-password', [UserController::class, 'ResetPasswordPage'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::post('password-reset', [UserController::class, 'ResetPassword'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::post('user-login', [UserController::class, 'userLogin']);
    Route::get('user-login', [UserController::class, 'patientLoginPage']);
    Route::get('verify-otp-page', [UserController::class, 'patientVerifyOtpPage'])->middleware([ResetPassTokenVerificationMiddleware::class]);
    Route::get('patient-login/{phone}', [UserController::class, 'patientLogin']);
    Route::get('patient-verify-otp/{phone}/{otp}', [UserController::class, 'patientVerifyOtp']);

