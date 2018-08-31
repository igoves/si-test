<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Get the projects for the user.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
