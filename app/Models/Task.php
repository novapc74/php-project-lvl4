<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id',
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\Users', 'created_by_id');
    }

    public function performer()
    {
        return $this->belongsTo('App\Models\Users', 'assigned_to_id');
    }

    public function statuses()
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }
}
