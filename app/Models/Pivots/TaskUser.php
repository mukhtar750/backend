<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskUser extends Pivot
{
    protected $table = 'task_user';
    
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    
    protected $fillable = [
        'status',
        'completed_at',
    ];
}
