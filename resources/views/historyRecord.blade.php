<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('plateRecording') }}"
               class="inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg shadow hover:bg-gray-300 dark:hover:bg-gray-600 transition"
               title="Quay lại trang ghi nhận xe">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Quay lại
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight tracking-wide">
                {{ __('Lịch Sử Ghi Nhận Xe') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"  style="margin-top: 30px">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ảnh</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Biển số</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Loại xe</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Thời gian vào</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Thời gian ra</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($vehicles as $index => $vehicle)
                                    <tr>
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">
                                            @if($vehicle->img)
                                                <img src="{{ $vehicle->img }}" alt="Ảnh xe" class="h-16 rounded shadow border border-gray-300">
                                            @else
                                                <span class="text-gray-400 italic">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 font-mono text-lg">{{ $vehicle->license_plate }}</td>
                                        <td class="px-4 py-2">{{ $vehicle->vehicle_type }}</td>
                                        <td class="px-4 py-2">{{ $vehicle->check_in_time }}</td>
                                        <td class="px-4 py-2">
                                            {{ $vehicle->check_out_time ?? 'Chưa có' }}
                                        </td>
                                        <td class="px-4 py-2 text-red-600 font-bold">
                                            {{ $vehicle->price ? number_format($vehicle->price) . ' VNĐ' : '0 VNĐ' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>