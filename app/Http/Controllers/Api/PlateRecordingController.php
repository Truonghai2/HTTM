<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlateRecording;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PlateRecordingController extends Controller
{

    // public function index()
    // {
    //     $vehicle = PlateRecording::findOrFail(1);
    //     return view('plateRecording', [
    //         'vehicle' => $vehicle,
    //     ]);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string',
            'vehicle_type' => 'required|string',
            'cam_type' => 'required|string', // bỏ dấu cách dư ở 'cam_type '
            'img' => 'required|url',
            'time' => 'required|date',
        ]);

        $plate = strtoupper(trim($validated['license_plate']));
        $camType = strtolower(trim($validated['cam_type'])); // 'in' hoặc 'out'
        $time = \Carbon\Carbon::parse($validated['time']);

        $existing = PlateRecording::where('license_plate', $plate)
            ->whereNull('check_out_time')
            ->orderByDesc('check_in_time')
            ->first();

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        if ($camType === 'in') {
            // Nếu đã active thì không thể vào
            if ($existing && $existing->status === 'active') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Xe đã có trong bãi, không thể vào tiếp.'
                ], 400);
            }

            $record = PlateRecording::create([
                'license_plate' => $plate,
                'vehicle_type' => $validated['vehicle_type'],
                'img' => $validated['img'],
                'cam_type' => 'in',
                'status' => 'active',
                'check_in_time' => $time,
            ]);

            $pusher->trigger('vehicle-channel', 'vehicle-updated', [
                'license_plate' => $record->license_plate,
                'vehicle_type' => $record->vehicle_type,
                'img' => $record->img,
                'time' => $record->check_in_time,
                'check_out_time' => null,
                'price' => null,
            ]);

            return response()->json([
                'status' => 'in',
                'message' => 'Xe mới được ghi nhận vào bãi.',
                'data' => $record
            ]);
        } elseif ($camType === 'out') {
            // Nếu không tồn tại hoặc status là in_active, không thể ra
            if (!$existing || $existing->status === 'in_active') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy xe trong bãi hoặc xe đã ra.'
                ], 400);
            }

            $existing->check_out_time = $time;
            $existing->price = $existing->calculatePrice();
            $existing->status = 'in_active';
            $existing->cam_type = 'out';
            $existing->save();

            $pusher->trigger('vehicle-channel', 'vehicle-updated', [
                'license_plate' => $existing->license_plate,
                'vehicle_type' => $existing->vehicle_type,
                'img' => $existing->img,
                'time' => $existing->check_in_time,
                'check_out_time' => $existing->check_out_time,
                'price' => $existing->price,
            ]);

            return response()->json([
                'status' => 'out',
                'message' => 'Xe đã được xử lý ra khỏi bãi.',
                'data' => $existing
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loại camera không hợp lệ. Phải là "in" hoặc "out".'
            ], 422);
        }
    }



    public function index(Request $request)
    {
        return view('plateRecording', [
            'vehicle' => PlateRecording::orderby('created_at', 'desc')->first(),
        ]);
    }


    public function history(Request $request)
    {
        $query = PlateRecording::query();

        // Filter by license plate
        if ($request->has('license_plate') && $request->license_plate) {
            $query->where('license_plate', 'like', '%' . $request->license_plate . '%');
        }

        // Filter by vehicle type
        if ($request->has('vehicle_type') && $request->vehicle_type) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('check_in_time', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('check_in_time', '<=', $request->end_date);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->get();

        return view('historyRecord', [
            'vehicles' => $vehicles,
            'filters' => $request->all()
        ]);
    }
}
