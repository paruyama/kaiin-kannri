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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 外部キーカラム
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('member_code')->nullable();
            // その他の会員情報カラム
            $table->foreign('user_id')->references('id')->on('users'); // 外部キー制約
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};