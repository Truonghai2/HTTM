<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlateRecordingController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/plate-recordings', [PlateRecordingController::class, 'store']); // gửi xe
// Route::post('/plate-recordings/{id}/checkout', [PlateRecordingController::class, 'checkout']); // xe ra
// Route::get('/plate-recordings', [PlateRecordingController::class, 'index']); // danh sách
// Route::get('/plate-recordings/{id}', [PlateRecordingController::class, 'show']); // chi tiết


Route::post('/plate-record', [PlateRecordingController::class, 'store']);
