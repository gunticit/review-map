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
            $table->string('url_map');
            $table->string('description');
            $table->string('package');
            $table->string('is_slow');
            $table->string('point_slow');
            $table->string('keyword');
            $table->boolean('has_image');
            $table->integer('status'); // 0: Huỷ, 1: Đang thực hiện, 2: Hoàn thành, 3: Hoàn lại, 4: Tạm ngưng
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
