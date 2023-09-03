<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_to_maps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('production_id')->nullable();
            $table->bigInteger('map_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_to_maps');
    }
};
