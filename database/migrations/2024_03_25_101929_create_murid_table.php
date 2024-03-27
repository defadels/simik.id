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

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama');
            $table->string('jenjang')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('urutan')->default(0);
        });

        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama'); 
            $table->string('keterangan')->nullable(); 
        });

        Schema::create('rombel', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama'); 
            $table->string('ruangan')->nullable(); 
            $table->integer('kapasitas')->nullable(); 
            $table->string('keterangan')->nullable(); 
            $table
                ->foreignId('kelas_id') 
                ->constrained('kelas')
                ->onDelete('cascade');
               
            $table
                ->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');
        });
 
        Schema::create('murid', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama');
            $table->string('nama_wali')->nullable();
            $table->string('kelas')->nullable();
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
        Schema::dropIfExists('murid');
    }
};
