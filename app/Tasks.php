<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
   protected $table = 'tasks';
   protected $fillable = [
		'id', 
		'name', 
		'description', 
		'reminder_date',
		'expiration_date',
    'user_id',
		'created_at',
		'updated_at'
   	];

   	 public function userTasks()
    {
        return $this->belongsTo('App\User', 'tasks', 'user_id');
    }

     public function taskStatus()
    {
        return $this->hasOne('App\TaskStatus');
    }
   	
}
