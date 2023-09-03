<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auftrags_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('name')->nullable();
            $table->string('kosten')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auftrags_types');
    }
};
