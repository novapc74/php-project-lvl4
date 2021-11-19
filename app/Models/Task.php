<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Label', 'task_label', 'task_id', 'label_id');
    }
}
