<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\TaskStatus');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Models\Label', 'task_label', 'task_id', 'label_id');
    }
}
