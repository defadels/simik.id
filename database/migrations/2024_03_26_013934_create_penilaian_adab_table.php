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
        Schema::create('penilaian_adab', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('laporan_id')->nullable()
            ->constrained('laporan')
            ->onDelete('cascade')
            ;
            $table->string('penilaian');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_adab');
    }
};
