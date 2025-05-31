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
        // Solo eliminar si existe la columna
        if (Schema::hasColumn('projects', 'project_type_id')) {
            Schema::table('projects', function (Blueprint $table) {
                // Laravel no siempre nombra igual las foreign keys, así que mejor usar try/catch
                try {
                    $table->dropForeign(['project_type_id']);
                } catch (\Exception $e) {
                    // Si la foreign key no existe, ignorar el error
                }
                try {
                    $table->dropColumn('project_type_id');
                } catch (\Exception $e) {
                    // Si la columna ya no existe, ignorar el error
                }
            });
        }
        // Solo eliminar la tabla si existe
        if (Schema::hasTable('project_types')) {
            Schema::dropIfExists('project_types');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('project_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_type_id')->after('description')->constrained()->onDelete('restrict');
        });
    }
};
