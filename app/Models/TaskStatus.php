<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $table = 'task_statuses';
    protected $fillable = [
    'name',
    ];

    public function tasks(): object
    {
        return $this->hasMany('App\Models\Task', 'status_id');
    }
}
