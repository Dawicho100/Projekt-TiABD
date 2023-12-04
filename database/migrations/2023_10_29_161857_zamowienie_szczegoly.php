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
        Schema::create('zamowienie_szczegoly', function (Blueprint $table) {
            $table->id();
            $table->integer('id_zamowinie');
            $table->integer('id_produkt');
            $table->integer('ilosc');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('zamowienie_szczegoly');

    }
};
