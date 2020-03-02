<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUsers extends Model
{
    protected $table = "project_users";
    protected $fillable = [
        'project_id', 'user_id', 'status', 'created_by','deleted_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
