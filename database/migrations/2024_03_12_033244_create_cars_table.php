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
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('carmake_id')->constrained()->on('car_makes')->comment('id модели');
            $table->string('name')->comment('название марки');
            $table->string('number')->comment('номер');
            $table->string('color')->comment('цвет');
            $table->string('status')->comment('статус');
            $table->json('damages')->nullable()->comment('повреждения');
            $table->string('STS')->nullable()->comment('СТС');
            $table->string('PTS')->nullable()->comment('ПТС');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
