<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
   protected $table = 'task_status';
   protected $fillable = [
   		'id', 
   		'tasks_id', 
   		'status',
   		'created_at',
   		'updated_at'
   	];
   	
}
