<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $table = 'projects';

    protected $guarded = [];

    public static function boot() {
        parent::boot();
    
        //once created/inserted successfully this method fired, so I tested foo 
        static::created(function ($model) {
            
            $logMessage = "User with ID: " . Auth::id() . " Created Project Data";
            Log::channel('userhistory')->info($logMessage, ['model' => $model]);
        });

        static::deleted(function ($model) {
            $logMessage = "User with ID: " . Auth::id() . " Deleted Project Data";
            Log::channel('userhistory')->info($logMessage, ['model' => $model]);
        });
    }

    /**
     * user relationship
     *
     * @return Collection
     */
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * tasks relationship
     *
     * @return Collection
     */
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'project_id', 'id');
    }

    /**
     * get total tasks
     *
     * @return Collection
     */
    public function getTotalTasks()
    {
        return sizeof($this->tasks);
    }
}
