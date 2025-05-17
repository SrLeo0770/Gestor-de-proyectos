<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea existente
            $table->dropForeign(['client_id']);
            
            // Modificar la columna para que apunte a la tabla clients
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropForeign(['client_id']);
            $table->foreign('client_id')->references('id')->on('users')->onDelete('restrict');
        });
    }
}; 