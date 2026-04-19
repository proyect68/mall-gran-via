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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'apellido_paterno')) {
                $table->string('apellido_paterno')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'apellido_materno')) {
                $table->string('apellido_materno')->nullable()->after('apellido_paterno');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'apellido_paterno')) {
                $table->dropColumn('apellido_paterno');
            }
            if (Schema::hasColumn('users', 'apellido_materno')) {
                $table->dropColumn('apellido_materno');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
