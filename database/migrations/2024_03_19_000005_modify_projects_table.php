<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('progress')->default(0);
            $table->integer('estimated_time')->comment('in hours');
            $table->integer('team_size');
            $table->json('resources')->nullable();
            $table->json('services')->nullable();
            $table->enum('completion_status', ['complete', 'incomplete', 'cancelled'])->nullable();
            $table->timestamp('last_audit')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'progress',
                'estimated_time',
                'team_size',
                'resources',
                'services',
                'completion_status',
                'last_audit'
            ]);
        });
    }
}; 