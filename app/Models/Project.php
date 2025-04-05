<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $guarded = [];

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
