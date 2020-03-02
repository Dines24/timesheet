<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use SoftDeletes;
    
    protected $table = "departments";
    protected $dates = ['deleted_at'];
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'name', 'is_active', 'created_by','deleted_at'
   ];

   public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

}
