<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('fillType')->nullable();
            $table->string('author')->nullable();
            $table->string('version')->nullable();
            $table->json('production')->nullable();
            $table->boolean('public_private')->default(false)->nullable();
            $table->boolean('isMod')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
