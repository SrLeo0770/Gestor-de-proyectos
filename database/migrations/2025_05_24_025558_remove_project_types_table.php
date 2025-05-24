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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['project_type_id']);
            $table->dropColumn('project_type_id');
        });

        Schema::dropIfExists('project_types');
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
