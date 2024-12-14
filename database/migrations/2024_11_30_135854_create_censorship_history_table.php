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
        Schema::create('censorship_history', function (Blueprint $table) {
            $table->id();
            $table->integer('approver_id'); // Người duyệt
            $table->integer('mission_id'); // Nhiệm vụ được duyệt
            $table->integer('partner_id'); // Đối tác
            $table->double('money', 15, 0)->nullable(); // Số tiền đối tác nhận
            $table->integer('status'); // 1: // Thành công, 2: // Thiếu Hình ảnh, 3: // Không thấy comment
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('sort')->default(99);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('censorship_history');
    }
};
