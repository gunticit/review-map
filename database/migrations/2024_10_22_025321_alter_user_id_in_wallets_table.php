<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            // Add unique constraint to user_id
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            // Remove the unique constraint
            $table->dropUnique(['user_id']);
        });
    }
};
