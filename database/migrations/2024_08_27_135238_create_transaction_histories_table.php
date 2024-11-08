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
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id'); // Id ví
            $table->enum('type', ['deposit', 'withdraw', 'payment', 'mined']); // nạp | rút | thanh toán | hoàn thành nhiệm vụ
            $table->string('transaction_code')->nullable();
            $table->decimal('amount', 15, 0); // Số tiền
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->integer('payment_method_id')->nullable(); // Id phương thức thanh toán
            $table->decimal('temp_balance')->nullable();
            $table->string('reference_id')->unique();
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
        Schema::dropIfExists('transaction_histories');
    }
};
