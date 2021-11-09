<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $createdBy
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id',
    ];

    public function createdBy(): object
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assignedTo(): object
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status(): object
    {
        return $this->belongsTo('App\Models\TaskStatus');
    }

    public function labels(): object
    {
        return $this->belongsToMany('App\Models\Label', 'task_label', 'task_id', 'label_id');
    }
}
