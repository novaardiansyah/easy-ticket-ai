<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_station_id')->constrained('stations')->cascadeOnDelete();
            $table->foreignId('destination_station_id')->constrained('stations')->cascadeOnDelete();
            $table->decimal('distance_km', 6, 2);
            $table->integer('estimated_duration');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
