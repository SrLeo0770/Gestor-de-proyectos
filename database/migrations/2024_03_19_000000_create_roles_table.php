<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert basic roles
        DB::table('roles')->insert([
            [
                'name' => 'Líder de Proyecto',
                'slug' => 'project_leader',
                'description' => 'Control total sobre proyectos y gestión de equipo',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Miembro del Equipo',
                'slug' => 'team_member',
                'description' => 'Puede ver y participar en proyectos asignados',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cliente',
                'slug' => 'client',
                'description' => 'Cliente del proyecto, solo puede ser creado por un líder',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}; 