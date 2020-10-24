<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{   
    protected $guarded = [];

    public function scopeGetNotif($query)
    {
        return $query->take(3)->oldest('read_at')->get();
    }

    public function scopeGetTotal($query)
    {
        return $query->whereNull('read_at')->count();
    }

    public function scopeGetNotifNew($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeGetNotifOld($query)
    {
        return $query->whereNotNull('read_at');
    }
}
