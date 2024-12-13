<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Khóa chính
            $table->unsignedBigInteger('user_id')->nullable(); // ID người dùng
            $table->string('ip_address', 45)->nullable(); // Địa chỉ IP người dùng
            $table->text('user_agent')->nullable(); // User agent của người dùng
            $table->longText('payload'); // Payload của phiên
            $table->integer('last_activity'); // Thời gian hoạt động cuối cùng
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}

