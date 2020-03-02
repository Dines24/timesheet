<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    protected $table = "user_permissions";
    protected $fillable = [
        'user_id', 'type', 'addproject', 'view', 'createtask', 'delete'
    ];
}
