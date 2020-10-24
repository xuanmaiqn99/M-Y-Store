<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    protected $primaryKey = 'command';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    	'command', 
    	'next_run', 
    	'last_run'
    ];
}
