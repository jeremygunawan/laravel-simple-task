<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

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
}
