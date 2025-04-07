<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PhotoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:20|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);

    event(new Registered($user));

    return response()->json([
        'message' => 'Пользователь успешно зарегистрирован. Проверьте вашу почту для подтверждения.',
    ]);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete(); // Удаляет все токены пользователя
    return response()->json(['message' => 'Logged out successfully']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/ads', [AdController::class, 'index']);
Route::post('/ads', [AdController::class, 'store'])->middleware('auth:sanctum');
Route::get('/ads/{category_slug}/{subcategory_slug?}', [AdController::class, 'index']);
Route::get('/ads/{category_slug}/{subcategory_slug}/{ad_slug}', [AdController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-photo', [PhotoController::class, 'upload']);
});
