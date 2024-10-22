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
        Schema::table('users', function (Blueprint $table) {
            // Xóa unique index hiện tại trước khi thêm lại
            $table->dropUnique('users_telephone_unique');

            // Thêm lại với thuộc tính nullable
            $table->string('telephone')->unique()->nullable()->change();
        });
    }

    public function down()
    {
       
    }
};
