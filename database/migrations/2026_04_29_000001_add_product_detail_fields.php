<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('nombre');
            }

            if (!Schema::hasColumn('productos', 'stock')) {
                $table->unsignedInteger('stock')->default(0)->after('precio');
            }
        });

        if (Schema::hasTable('producto_imagenes')) {
            Schema::table('producto_imagenes', function (Blueprint $table) {
                if (!Schema::hasColumn('producto_imagenes', 'titulo')) {
                    $table->string('titulo')->nullable();
                }

                if (!Schema::hasColumn('producto_imagenes', 'alt')) {
                    $table->string('alt')->nullable();
                }

                if (!Schema::hasColumn('producto_imagenes', 'orden')) {
                    $table->unsignedInteger('orden')->default(0);
                }

                if (!Schema::hasColumn('producto_imagenes', 'principal')) {
                    $table->boolean('principal')->default(false);
                }

                if (!Schema::hasColumn('producto_imagenes', 'created_at')) {
                    $table->timestamps();
                }
            });
        } else {
            Schema::create('producto_imagenes', function (Blueprint $table) {
                $table->id('id_imagen');
                $table->foreignId('id_producto')->constrained('productos')->cascadeOnDelete();
                $table->string('url');
                $table->string('titulo')->nullable();
                $table->string('alt')->nullable();
                $table->unsignedInteger('orden')->default(0);
                $table->boolean('principal')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('producto_variantes')) {
            Schema::create('producto_variantes', function (Blueprint $table) {
                $table->id('id_variante');
                $table->foreignId('id_producto')->constrained('productos')->cascadeOnDelete();
                $table->string('titulo');
                $table->string('tipo')->default('modelo');
                $table->string('valor')->nullable();
                $table->string('imagen')->nullable();
                $table->unsignedInteger('orden')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_variantes');
        Schema::dropIfExists('producto_imagenes');

        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'stock')) {
                $table->dropColumn('stock');
            }

            if (Schema::hasColumn('productos', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
        });
    }
};
