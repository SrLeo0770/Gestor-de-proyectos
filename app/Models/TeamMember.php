<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'role',
        'department',
        'position',
        'skills',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team', 'user_id', 'project_id')
                    ->withTimestamps();
    }
} 