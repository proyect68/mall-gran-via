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
        Schema::table('productos', function (Blueprint $table) {
            // Añadir columna de relación a tiendas de forma opcional
            if (!Schema::hasColumn('productos', 'tienda_id')) {
                $table->foreignId('tienda_id')
                    ->nullable()
                    ->constrained('tiendas')
                    ->onDelete('set null')
                    ->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'tienda_id')) {
                $table->dropForeign(['tienda_id']);
                $table->dropColumn('tienda_id');
            }
        });
    }
};
