<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Task extends Model
{
    protected $table = 'tasks';

    protected $guarded = [];

    protected $appends = ['project_name', 'created_date'];

    public static function boot() {
        parent::boot();
    
        //once created/inserted successfully this method fired, so I tested foo 
        static::created(function ($model) {
            $logMessage = "User with ID: " . Auth::id() . " Created Task Data";
            Log::channel('userhistory')->info($logMessage, ['model' => $model]);
        });

        static::deleted(function ($model) {
            $logMessage = "User with ID: " . Auth::id() . " Deleted Task Data";
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
     * project relationship
     *
     * @return Collection
     */
    public function project()
    {
        return $this->hasOne(\App\Models\Project::class, 'id', 'project_id');
    }

    /**
     * project relationship
     *
     * @return Collection
     */
    public function getProjectName()
    {
        return $this->project->name;
    }

    /**
     * Append attribute project name
     *
     * @return Collection
     */
    public function getProjectNameAttribute(){
        return $this->getProjectName();
    }

    /**
     * Append attribute project name
     *
     * @return Collection
     */
    public function getCreatedDateAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
