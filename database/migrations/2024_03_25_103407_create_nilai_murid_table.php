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
        Schema::create('nilai_murid', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('capwaktu')->nullable();
            $table->date('tanggal')->nullable()->index();
            $table->string('penilaian')->nullable();
            $table->string('materi')->nullable();
            $table->string('sub_materi')->nullable();
            $table->integer('no_murid')->nullable();
            $table->string('nama')->nullable();
            $table->string('kehadiran')->nullable();
            $table->string('indikator_1_label')->nullable();
            $table->integer('indikator_1_nilai')->nullable(); 
            $table->string('indikator_2_label')->nullable();
            $table->integer('indikator_2_nilai')->nullable(); 
            $table->string('indikator_3_label')->nullable();
            $table->integer('indikator_3_nilai')->nullable(); 
            $table->float('rata_rata_nilai')->nullable(); 
            $table->string('predikat')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('saran')->nullable();

            $table->foreignId('matapelajaran_id')->nullable()
                ->constrained('matapelajaran')
                ->onDelete('cascade')
                ;
                
            $table->foreignId('murid_id')->nullable()
                ->constrained('murid')
                ->onDelete('cascade')
                ;               
             

            $table->foreignId('rombel_id')->nullable()
                ->constrained('rombel')
                ->onDelete('cascade')
                ;               
            });
    } 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_murid');
    }
};
