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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('first_name')->comment('Имя');
            $table->string('middle_name')->comment('Фамилия');
            $table->string('last_name')->nullable()->comment('Отчество');
            $table->string('email')->comment('Email');
            $table->char('phone_number', 11)->nullable()->comment('Номер телефона');
            $table->string('password')->comment('Пароль');
            $table->string('city')->nullable()->comment('Город');
            $table->string('passport')->nullable()->comment('Паспорт');
            $table->string('licence')->nullable()->comment('Водительские права');
            $table->remember_token('remember_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
