<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng lưu trữ thông tin người nhận sau có thể dùng lại
     */
    public function up(): void
    {
        Schema::create('contact_order', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('telephone');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_order');
    }
};
