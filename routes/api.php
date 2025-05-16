<?php


use App\Http\Controllers\Api\PlateRecordingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


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


Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Thông tin đăng nhập không đúng'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
    ]);
});
