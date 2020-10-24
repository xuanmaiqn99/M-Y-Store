<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cron;

class CronController extends Controller
{
    public static function task($command, $minutes, $time) {
        $cron = Cron::find($command);
        $now  = Carbon::now();
        if ($cron && $cron->next_run > $now->timestamp) {
            return false;
        }
        $arr = $time.split(':');
        Cron::updateOrCreate(
            [
            	'command'  => $command
            ],
            [
            	'next_run' => Carbon::now()->addMinutes($minutes)->timestamp,
             	'last_run' => Carbon::create(
             		null, 
             		null, 
             		null, 
             		intval($arr[0]), 
             		intval($arr[1]),
             		0
             	)->timestamp
         	]
        );
        return true;
	}
}
