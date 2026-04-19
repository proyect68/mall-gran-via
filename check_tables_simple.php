<?php
// Verificar tablas en BD
use Illuminate\Support\Facades\DB;

$tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema='public' ORDER BY table_name");

foreach ($tables as $table) {
    if (strpos($table->table_name, 'categor') !== false || strpos($table->table_name, 'product') !== false || strpos($table->table_name, 'subcategor') !== false) {
        echo $table->table_name . "\n";
    }
}
