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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url_map')->nullable();
            $table->string('description')->nullable();
            $table->string('package')->nullable();
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
            $table->integer('status'); // 0: Huỷ, 1: Hoàn thành, 2: Đang thực hiện, 3: Hoàn lại, 4: Tạm ngưng, 5: Chưa thanh toán
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
