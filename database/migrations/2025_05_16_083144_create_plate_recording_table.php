<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plate_recording', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate');
            $table->string('vehicle_type');
            $table->text('img');
            $table->string('cam_type');
            $table->string('status')->default('in_active');
            $table->timestamp('check_in_time')->useCurrent();
            $table->timestamp('check_out_time')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plate_recording');
    }
};
