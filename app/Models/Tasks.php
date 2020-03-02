<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tasks extends Model
{
    use SoftDeletes;
    //
    public function user()
    {
        return $this->belongsTo('App\User', 'assign_to');
    }
    public function Project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
    public function Departments()
    {
        return $this->belongsTo('App\Models\Departments', 'department');
    }
}
