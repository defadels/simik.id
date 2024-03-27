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
        Schema::create('matapelajaran', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama'); 
            $table->integer('kode_grafik')->nullable();
            $table->string('label_1')->nullable();
            $table->string('label_2')->nullable();
            $table->string('label_3')->nullable();
            $table->string('label_4')->nullable();
            $table->string('label_5')->nullable();
            $table->string('label_6')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matapelajaran');
    }
};
