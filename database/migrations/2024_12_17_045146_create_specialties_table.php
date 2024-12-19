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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id('specialty_id'); // ID chuyên khoa
            $table->string('specialty'); // Tên chuyên khoa
            $table->string('mota'); // Mô tả chuyên khoa
            $table->unsignedBigInteger('created_by')->nullable(); // ID người tạo
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};
