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

    public function storeFromAI(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string',
            'vehicle_type' => 'required|string',
            'img' => 'required|url',
            'time' => 'required|date',
        ]);

        $plate = strtoupper(trim($validated['license_plate']));

        $existing = PlateRecording::where('license_plate', $plate)
            ->whereNull('check_out_time')
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

        if ($existing) {
            $existing->check_out_time = \Carbon\Carbon::parse($validated['time']);
            $existing->price = $existing->calculatePrice();
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
                'message' => 'Xe đã được xử lý ra bãi',
                'data' => $existing
            ]);
        }

        $record = PlateRecording::create([
            'license_plate' => $plate,
            'vehicle_type' => $validated['vehicle_type'],
            'img' => $validated['img'],
            'check_in_time' => \Carbon\Carbon::parse($validated['time']),
        ]);

        $pusher->trigger('vehicle-channel', 'vehicle-updated', [
            'license_plate' => $record->license_plate,
            'vehicle_type' => $record->vehicle_type,
            'img' => $record->img,
            'time' => $record->check_in_time,
            'check_out_time' => $record->check_out_time,
            'price' => $record->price,
        ]);

        return response()->json([
            'status' => 'in',
            'message' => 'Xe mới được ghi nhận vào bãi',
            'data' => $record
        ]);
    }


    public function index(Request $request) 
    {
        return view('plateRecording', [
            'vehicle' => PlateRecording::orderby('created_at', 'desc')->first(),
        ]);
    }

    public function history(Request $request) 
    {
        return view('historyRecord', [
            'vehicles' => PlateRecording::orderby('created_at', 'desc')->all(),
        ]);
    }
}
