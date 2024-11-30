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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('balance', 15, 0)->default(0); // Số dư của ví
            $table->string('unit_currency', 10)->default('VND'); // Loại tiền tệ
            $table->decimal('provisional_deduction', 15, 0)->default(0); // Số tiền trừ tạm thời
            $table->decimal('temporary_addition', 15, 0)->default(0); // Số tiền cộng tạm thời
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
        Schema::dropIfExists('wallets');
    }
};
