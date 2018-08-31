<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
