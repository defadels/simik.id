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
        Schema::create('rating_adab', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('penilaian_adab_id')->nullable()
            ->constrained('penilaian_adab')
            ->onDelete('cascade')
            ;
            $table->foreignId('murid_id')->nullable()
            ->constrained('murid')
            ->onDelete('cascade')
            ;  
            $table->integer('rating')->default(0); 
            $table->string('predikat')->nullable();
            $table->string('deskripsi')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_adab');
    }
};
