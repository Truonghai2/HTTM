<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlateRecording extends Model
{
    use HasFactory;

    protected $table = 'plate_recording';


    protected $fillable = [
        'license_plate',
        'vehicle_type',
        'check_in_time',
        'check_out_time',
        'cam_tpye',
        'status',
        'img',
        'price'
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    // Tính tiền (ví dụ: 3.000 VNĐ/giờ)
    public function calculatePrice(): int
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return 0;
        }

        $hours = max(1, $this->check_in_time->diffInHours($this->check_out_time));

        // Tính giá theo loại xe
        $rate = 0;

        switch (strtolower($this->vehicle_type)) {
            case 'ô tô':
            case 'oto':
            case 'xe ô tô':
                $rate = 20000;
                break;

            case 'xe máy':
            case 'xemay':
            case 'xe may':
                $rate = 5000;
                break;

            default:
                $rate = 3000; // giá mặc định
                break;
        }

        return $hours * $rate;
    }
}
