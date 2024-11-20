<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogActivityTrait
{
    protected static function bootLogActivityTrait()
    {
        static::created(function ($model) {
            static::logActivity('created', $model);
        });

        static::updated(function ($model) {
            static::logActivity('updated', $model);
        });

        static::deleted(function ($model) {
            static::logActivity('deleted', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        $user = auth()->user();
        $logData = [
            'user_name' => $user ? $user->name : 'Guest',
            'action'  => $action,
            'model'   => get_class($model),
            'data'    => $model->getAttributes(),
            'time'    => now(),
        ];

        Log::channel('activity')->info('Model ' . $action, $logData);
    }
}
