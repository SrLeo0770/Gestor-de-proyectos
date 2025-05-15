<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_type_id')->after('id')->constrained('project_types');
            $table->foreignId('category_id')->after('project_type_id')->constrained('categories');
            $table->foreignId('leader_id')->after('category_id')->constrained('users');
            $table->foreignId('client_id')->after('leader_id')->constrained('users');
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
            $table->dropForeign(['project_type_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['leader_id']);
            $table->dropForeign(['client_id']);
            $table->dropColumn([
                'project_type_id',
                'category_id',
                'leader_id',
                'client_id',
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