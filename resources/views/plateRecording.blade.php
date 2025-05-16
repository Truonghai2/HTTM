<!-- filepath: e:\Users\laravel\resources\views\plateRecording.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight tracking-wide">
                {{ __('Thông Tin Ghi Nhận Xe') }}
            </h2>
            <a href="{{ route('plateRecording.history') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Xem lịch sử
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-2">
                            <h2 class="text-2xl font-bold text-red-600 mb-6 tracking-wide">THÔNG TIN XE</h2>
                            <div class="space-y-4 text-lg">
                                <div class="flex items-center">
                                    <span class="w-40 font-semibold text-gray-700 dark:text-gray-300">Biển số:</span>
                                    <span id="license_plate" class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-mono text-xl tracking-widest">
                                        {{ $vehicle->license_plate ?? '' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-40 font-semibold text-gray-700 dark:text-gray-300">Loại xe:</span>
                                    <span id="vehicle_type" class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                        {{ $vehicle->vehicle_type ?? '' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-40 font-semibold text-gray-700 dark:text-gray-300">Thời gian vào:</span>
                                    <span id="time" class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                        {{ $vehicle->time ?? '' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-40 font-semibold text-gray-700 dark:text-gray-300">Thời gian ra:</span>
                                    <span id="check_out_time" class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                        {{ $vehicle->check_out_time ?? 'Chưa có' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-40 font-semibold text-gray-700 dark:text-gray-300">Giá tiền:</span>
                                    <span class="text-red-600 font-bold text-2xl" id="price">
                                        {{ isset($vehicle) && $vehicle->price ? number_format($vehicle->price) . ' VNĐ' : '0 VNĐ' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex flex-col items-center p-2">
                            <h2 class="text-2xl font-bold text-blue-600 mb-6 tracking-wide">HÌNH ẢNH CAMERA</h2>
                            <div id="img_container" class="w-full flex justify-center items-center min-h-[250px]">
                                @if(isset($vehicle) && $vehicle->img)
                                    <img id="vehicle_img" src="{{ $vehicle->img }}" alt="Ảnh xe" class="rounded-xl border border-gray-300 shadow-md max-h-72 object-contain">
                                @else
                                    <p id="no_img" class="text-gray-400 italic">Không có ảnh</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>