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
        Schema::table('users', function (Blueprint $table) {
            
        $table->unsignedBigInteger('role_id')->after('id');
        $table->foreign('role_id')->references('id')->on('roles');
        $table->boolean('is_active')->nullable();
        $table->string('user_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropColumn('is_active');
            $table->dropColumn('user_image');
        });
    }
};
