<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Las columnas 'phone' y 'position' ya existen en la tabla 'users', no es necesario agregarlas de nuevo.
    }

    public function down(): void
    {
        // Las columnas 'phone' y 'position' ya existen en la tabla 'users', no es necesario eliminarlas aquí.
    }
};