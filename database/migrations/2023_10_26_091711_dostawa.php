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
        Schema::create('dostawa', function (Blueprint $table) {
            $table->id();
            $table->string('name') -> unique();
            $table->integer('cena');
            $table->string('how_long');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('dostawa');
    }
};
