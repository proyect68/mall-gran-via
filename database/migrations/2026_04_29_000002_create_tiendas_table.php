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
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->integer('seguidores')->default(0);
            $table->float('calificacion')->nullable()->default(null); // Puntuación 1-5 calculada desde reseñas
            $table->string('piso_local')->nullable(); // Ej: "Piso 2, Local 205"
            $table->enum('estado', ['abierto', 'cerrado'])->default('abierto');
            $table->json('horario')->nullable(); // JSON con horarios por día
            $table->string('telefono')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiendas');
    }
};
