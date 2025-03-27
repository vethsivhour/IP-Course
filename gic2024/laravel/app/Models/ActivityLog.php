<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['model', 'model_id', 'action', 'changes'];
    protected $casts = ['changes' => 'array'];
}
