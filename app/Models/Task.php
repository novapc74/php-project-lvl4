<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->belongsTo('App\Models\Users', 'created_by_id');
    }

    public function performer()
    {
        return $this->belongsTo('App\Models\Users', 'assigned_to_id');
    }
}
