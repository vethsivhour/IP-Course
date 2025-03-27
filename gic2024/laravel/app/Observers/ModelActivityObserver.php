<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ModelActivityObserver
{
    public function created(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'created',
            'changes' => $model->toArray()
        ]);
    }

    public function updated(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'updated',
            'changes' => [
                'old' => $model->getOriginal(),
                'new' => $model->getChanges()
            ]
        ]);
    }

    public function deleted(Model $model): void
    {
        ActivityLog::create([
            'model' => get_class($model),
            'model_id' => $model->id,
            'action' => 'deleted',
            'changes' => $model->toArray()
        ]);
    }
}
