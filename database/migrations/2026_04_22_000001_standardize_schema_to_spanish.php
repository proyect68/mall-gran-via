<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->dropEmptyDuplicatesBeforeRename();
        $this->renameCategorySchema();
        $this->renameProductSchema();
        $this->normalizeRoles();
        $this->dropLegacyPivotAndDuplicateConstraints();
    }

    public function down(): void
    {
        if (Schema::hasTable('productos')) {
            Schema::table('productos', function (Blueprint $table) {
                if (Schema::hasColumn('productos', 'categoria_id')) {
                    $table->renameColumn('categoria_id', 'category_id');
                }
                if (Schema::hasColumn('productos', 'es_servicio')) {
                    $table->renameColumn('es_servicio', 'is_service');
                }
                if (Schema::hasColumn('productos', 'expira')) {
                    $table->renameColumn('expira', 'expires');
                }
                if (Schema::hasColumn('productos', 'imagen')) {
                    $table->renameColumn('imagen', 'image');
                }
                if (Schema::hasColumn('productos', 'oferta')) {
                    $table->renameColumn('oferta', 'offer');
                }
                if (Schema::hasColumn('productos', 'precio_anterior')) {
                    $table->renameColumn('precio_anterior', 'old_price');
                }
                if (Schema::hasColumn('productos', 'precio')) {
                    $table->renameColumn('precio', 'price');
                }
                if (Schema::hasColumn('productos', 'tienda')) {
                    $table->renameColumn('tienda', 'store');
                }
                if (Schema::hasColumn('productos', 'nombre')) {
                    $table->renameColumn('nombre', 'name');
                }
            });

            Schema::rename('productos', 'products');
        }

        if (Schema::hasTable('categorias')) {
            Schema::table('categorias', function (Blueprint $table) {
                if (Schema::hasColumn('categorias', 'descripcion')) {
                    $table->renameColumn('descripcion', 'description');
                }
                if (Schema::hasColumn('categorias', 'imagen')) {
                    $table->renameColumn('imagen', 'image');
                }
                if (Schema::hasColumn('categorias', 'nombre')) {
                    $table->renameColumn('nombre', 'name');
                }
            });

            Schema::rename('categorias', 'categories');
        }

        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (Schema::hasColumn('roles', 'id')) {
                    $table->renameColumn('id', 'id_rol');
                }
                if (Schema::hasColumn('roles', 'nombre')) {
                    $table->renameColumn('nombre', 'nombre_rol');
                }
            });
        }

        if (Schema::hasColumn('users', 'rol_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('rol_id');
            });
        }

        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('cliente')->after('password');
            });
        }
    }

    private function dropEmptyDuplicatesBeforeRename(): void
    {
        foreach (['categorias', 'productos'] as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            if (DB::table($table)->count() > 0) {
                throw new RuntimeException("La tabla {$table} contiene datos. No se eliminará automáticamente.");
            }

            DB::statement("DROP TABLE {$table} CASCADE");
        }
    }

    private function renameCategorySchema(): void
    {
        if (!Schema::hasTable('categories')) {
            return;
        }

        Schema::rename('categories', 'categorias');

        Schema::table('categorias', function (Blueprint $table) {
            if (Schema::hasColumn('categorias', 'name')) {
                $table->renameColumn('name', 'nombre');
            }
            if (Schema::hasColumn('categorias', 'image')) {
                $table->renameColumn('image', 'imagen');
            }
            if (Schema::hasColumn('categorias', 'description')) {
                $table->renameColumn('description', 'descripcion');
            }
        });
    }

    private function renameProductSchema(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        Schema::rename('products', 'productos');

        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'name')) {
                $table->renameColumn('name', 'nombre');
            }
            if (Schema::hasColumn('productos', 'store')) {
                $table->renameColumn('store', 'tienda');
            }
            if (Schema::hasColumn('productos', 'price')) {
                $table->renameColumn('price', 'precio');
            }
            if (Schema::hasColumn('productos', 'old_price')) {
                $table->renameColumn('old_price', 'precio_anterior');
            }
            if (Schema::hasColumn('productos', 'offer')) {
                $table->renameColumn('offer', 'oferta');
            }
            if (Schema::hasColumn('productos', 'image')) {
                $table->renameColumn('image', 'imagen');
            }
            if (Schema::hasColumn('productos', 'expires')) {
                $table->renameColumn('expires', 'expira');
            }
            if (Schema::hasColumn('productos', 'is_service')) {
                $table->renameColumn('is_service', 'es_servicio');
            }
            if (Schema::hasColumn('productos', 'category_id')) {
                $table->renameColumn('category_id', 'categoria_id');
            }
        });
    }

    private function normalizeRoles(): void
    {
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (Schema::hasColumn('roles', 'id_rol')) {
                    $table->renameColumn('id_rol', 'id');
                }
                if (Schema::hasColumn('roles', 'nombre_rol')) {
                    $table->renameColumn('nombre_rol', 'nombre');
                }
            });
        } else {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre')->unique();
            });
        }

        DB::table('roles')->upsert([
            ['id' => 1, 'nombre' => 'cliente'],
            ['id' => 2, 'nombre' => 'comerciante'],
            ['id' => 3, 'nombre' => 'administrador'],
            ['id' => 4, 'nombre' => 'super_admin'],
        ], ['id'], ['nombre']);

        if (!Schema::hasColumn('users', 'rol_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('rol_id')->nullable()->after('password');
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            DB::statement("
                UPDATE users
                SET rol_id = CASE LOWER(role)
                    WHEN 'cliente' THEN 1
                    WHEN 'user' THEN 1
                    WHEN 'comerciante' THEN 2
                    WHEN 'admin' THEN 3
                    WHEN 'administrador' THEN 3
                    WHEN 'super-admin' THEN 4
                    WHEN 'super_admin' THEN 4
                    ELSE 1
                END
                WHERE rol_id IS NULL
            ");
        }

        if (Schema::hasTable('usuario_rol')) {
            DB::statement("
                UPDATE users u
                SET rol_id = ur.id_rol
                FROM usuario_rol ur
                WHERE ur.user_id = u.id
                  AND u.rol_id IS NULL
            ");
        }

        DB::table('users')->whereNull('rol_id')->update(['rol_id' => 1]);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('rol_id')->references('id')->on('roles')->cascadeOnUpdate()->restrictOnDelete();
        });

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    private function dropLegacyPivotAndDuplicateConstraints(): void
    {
        $duplicateConstraints = [
            ['interacciones', 'fk_interaccion_producto'],
            ['interacciones', 'fk_interaccion_tienda'],
            ['ofertas', 'fk_oferta_producto'],
            ['producto_color', 'fk_producto_color_color'],
            ['producto_color', 'fk_producto_color_producto'],
            ['producto_imagenes', 'fk_producto_imagen'],
            ['producto_talla', 'fk_producto_talla_producto'],
            ['producto_talla', 'fk_producto_talla_talla'],
            ['resenas_producto', 'fk_resena_producto'],
            ['seguidores_tienda', 'fk_seguidor_tienda'],
            ['tienda_propietario', 'fk_tienda_propietario_tienda'],
            ['usuario_notificacion', 'fk_usuario_notif_notificacion'],
            ['usuario_rol', 'fk_usuario_rol_rol'],
        ];

        foreach ($duplicateConstraints as [$table, $constraint]) {
            if (Schema::hasTable($table)) {
                DB::statement("ALTER TABLE {$table} DROP CONSTRAINT IF EXISTS {$constraint}");
            }
        }

        if (Schema::hasTable('usuario_rol')) {
            Schema::drop('usuario_rol');
        }
    }
};
