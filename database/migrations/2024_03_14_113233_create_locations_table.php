<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('locations', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('car_id');
        $table->point('coordinates')->nullable();
        // $table->geography('coordinates', subtype: 'point', srid: 4326);
        $table->timestamps();
    });
    // DB::statement('ALTER TABLE locations ADD COLUMN coordinates_geog geography(Point, 4326)');
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
