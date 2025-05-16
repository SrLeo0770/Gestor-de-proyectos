<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'slug' => 'admin',
            'description' => 'Control total sobre el sistema',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->where('slug', 'admin')->delete();
    }
}; 