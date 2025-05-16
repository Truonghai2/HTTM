<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thông tin xe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans p-4">
    <div class="grid grid-cols-2 gap-4">
        <!-- Thông tin xe -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-red-600 mb-4">THÔNG TIN XE</h2>

            <p><span class="font-semibold">Biển số:</span> {{ $vehicle->license_plate }}</p>
            <p><span class="font-semibold">Loại xe:</span> {{ $vehicle->vehicle_type }}</p>
            <p><span class="font-semibold">Thời gian vào:</span> {{ $vehicle->time }}</p>
            <p><span class="font-semibold">Thời gian ra:</span> {{ $vehicle->check_out_time ?? 'Chưa có' }}</p>
            <p><span class="font-semibold">Giá tiền:</span>
                <span class="text-red-600 font-bold text-xl">
                    {{ $vehicle->price ? number_format($vehicle->price) . ' VNĐ' : '0 VNĐ' }}
                </span>
            </p>
        </div>

        <!-- Hình ảnh camera -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-blue-600 mb-4">HÌNH ẢNH CAMERA</h2>
            @if ($vehicle->img)
            <img src="{{ $vehicle->img }}" alt="Ảnh xe" class="rounded-lg border border-gray-300 shadow-md">
            @else
            <p>Không có ảnh</p>
            @endif
        </div>
    </div>
</body>

</html>