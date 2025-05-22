<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('layout.Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('layout.Welcome') }}, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('layout.You\'re logged in!') }}
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Plate Recording Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Ghi nhận xe
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Xem và quản lý thông tin ghi nhận xe vào/ra bãi đỗ xe
                        </p>
                        <a href="{{ route('plateRecording') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Xem chi tiết
                        </a>
                    </div>
                </div>

                <!-- History Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Lịch sử ghi nhận
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Xem lịch sử ghi nhận xe và tìm kiếm thông tin
                        </p>
                        <a href="{{ route('plateRecording.history') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Xem lịch sử
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
