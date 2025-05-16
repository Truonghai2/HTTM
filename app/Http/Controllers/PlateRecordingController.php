<?php

namespace App\Http\Controllers;

use App\Models\PlateRecording;
use Illuminate\Http\Request;

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

        if ($existing) {
            $existing->check_out_time = \Carbon\Carbon::parse($validated['time']);
            $existing->price = $existing->calculatePrice();
            $existing->save();

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

        return response()->json([
            'status' => 'in',
            'message' => 'Xe mới được ghi nhận vào bãi',
            'data' => $record
        ]);
    }
}
