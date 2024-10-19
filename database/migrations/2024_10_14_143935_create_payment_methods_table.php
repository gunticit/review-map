<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phương thức thanh toán
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['momo','bank','vnpay','visa','paypal']); // Tên phương thức thanh toán
            $table->string('owner_name'); // tên chủ sở hữu
            $table->string('account_number'); // Số tài khoản
            $table->string('bank_name')->nullable(); // Tên ngân hàng
            $table->string('bank_branch')->nullable(); // Tên chi nhánh
            $table->text('note')->nullable();
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
        Schema::dropIfExists('payment_methods');
    }
};
