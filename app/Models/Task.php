<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $guarded = [];

    protected $appends = ['project_name', 'created_date'];

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
