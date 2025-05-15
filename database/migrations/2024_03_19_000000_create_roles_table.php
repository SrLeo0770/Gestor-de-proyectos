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
            $table->timestamps();
        });

        // Insert basic roles
        DB::table('roles')->insert([
            ['name' => 'Administrador', 'slug' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Líder de Proyecto', 'slug' => 'project_leader', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Miembro del Equipo', 'slug' => 'team_member', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cliente', 'slug' => 'client', 'created_at' => now(), 'updated_at' => now()],
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