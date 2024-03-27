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
        Schema::create('detil_laporan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('jenis', ['mapel','opening','closing','adab'])->indexed();
            $table->foreignId('laporan_id')->nullable()
            ->constrained('laporan')
            ->onDelete('cascade')
            ;
            $table->foreignId('matapelajaran_id')->nullable()
            ->constrained('matapelajaran')
            ->onDelete('cascade')
            ;
            $table->foreignId('murid_id')->nullable()
                ->constrained('murid')
                ->onDelete('cascade')
                ;  
            $table->text('deskripsi')->nullable(); 
            $table->text('saran')->nullable(); 
            $table->string('catatan')->nullable(); 
            $table->string('lampiran')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detil_laporan');
    }
};
