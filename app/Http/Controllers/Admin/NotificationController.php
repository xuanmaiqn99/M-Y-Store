<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Events\OrderEvent;

class NotificationController extends Controller
{
    public function view($id)
    {
    	$not = Notification::findOrFail($id);
        if ($not->status == 0) {
        	$not->update([
        		'read_at' => now()
        	]);
            event( new OrderEvent('false', $id));
        }
    	
    	return redirect()->route('order.detail', ['id' => $not->notifiable_id]);

    }

    public function viewAll()
    {
    	if (Notification::getNotifNew()->count() > 0) {
            event( new OrderEvent('true', null));
        }
        Notification::getNotifNew()->update([
    		'read_at' => now()
    	]);

    	return redirect()->route('order.index'); 
    }
}
