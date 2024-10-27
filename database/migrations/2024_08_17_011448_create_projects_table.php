<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dự án mỗi chỉ sử dụng 1 lần nếu muốn chạy tiếp thì tạo dự án mới
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('project_code')->nullable();
            $table->string('url_map')->nullable();
            $table->string('description')->nullable();
            $table->string('package')->nullable(); // 1: 10, 2: 50, 3: 100, 4: 200
            $table->string('name_google')->nullable(); // Tên thực thể trên google map
            $table->string('address_google')->nullable();
            $table->string('telephone_google')->nullable();
            $table->double('rating_google')->nullable(); // Giá trị rating Google
            $table->double('total_rating_google')->nullable(); // Tổng giá trị rating Google
            $table->double('rating_desire')->nullable(); // Rating mong muốn
            $table->string('is_slow')->nullable(); // Rải chậm
            $table->string('point_slow')->nullable(); // Điểm chậm
            $table->string('keyword')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('place_id')->nullable();
            $table->boolean('has_image')->default(false)->nullable();
            $table->integer('status'); // 0: Huỷ, 1: Hoàn thành, 2: Đang thực hiện, 3: Hoàn lại, 4: Tạm ngưng, 5: Chưa thanh toán, 6: Đang chờ duyệt (khi hoàn thành nhiệm vụ)
            $table->integer('is_wrong_image')->default(0)->nullable();
            $table->date('update_wrong_image')->nullable(); // Ngày cập nhật lại hình
            $table->integer('is_wrong_rate')->default(0)->nullable();
            $table->date('update_wrong_rate')->nullable(); // Ngày cập nhật lại rate
            $table->enum('is_payment', [1,2])->nullable(); // 1: Đã thanh toán, 2: Chưa thanh toán
            $table->string('voucher_code')->nullable(); // Mã voucher áp dụng cho dự án
            $table->decimal('price', 15, 0)->nullable(); // Lưu lại khi đã thanh toán
            // Dành cho admin
            $table->integer('id_confirm')->nullable();
            $table->timestamp('id_confirm_at')->nullable();
            $table->integer('id_cancel')->nullable();
            $table->string('content_cancel')->nullable();
            $table->timestamp('id_cancel_at')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
