<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nếu mission được tạo project đang được thực hiện
     * 
     *  Status: Sau khi đối tác làm xong thì có 2 trường hợp:
     *  TH1: Nếu mission có image_id thì: 
     *  + Trạng thái sẽ là chờ hệ thống duyệt
     *  + Sau khi hệ thống duyệt là chờ nhân viên duyệt
     * 
     *  TH2: Nếu mission không image_id thì:
     *  + Trạng thái sẽ phụ thuộc vào admin thiết lập (bằng tay hay hệ thống)
     *  
     *  -----------------
     *  Status: Từ chối
     *  + Hệ thống: Phụ thuộc vào X,Y admin thiết lập (X số giờ, Y số lần)
     *  + Duyệt bằng tay
     */


    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('price', 15, 0)->default(0); // Đơn vị mặc định VNĐ
            $table->integer('project_id');
            $table->integer('comment_id');
            $table->integer('image_id')->nullable(); // Có thể có hoặc không, có liên quan đến trạng thái
            // Status chú ý comment phía trên
            $table->integer('status'); // 2: Đang thực hiện, 1: Đã hoàn thành, 3: Chờ hệ thống duyệt, 4: Chờ nhân viên duyệt, 5: Đã từ chối, 6: Đã hết hạn 
            $table->boolean('no_image')->nullable();
            $table->boolean('no_review')->nullable();
            $table->dateTime('checked_at')->nullable();
            $table->integer('num_check')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('link_confirm')->nullable();
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
        Schema::dropIfExists('missions');
    }
};
