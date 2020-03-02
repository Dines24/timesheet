<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designations extends Model
{
    use SoftDeletes;
    
    protected $table = "designation";
    protected $dates = ['deleted_at'];
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'name', 'is_active', 'created_by'
   ];
   public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
