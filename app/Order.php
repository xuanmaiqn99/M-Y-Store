<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Order;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function address()
    {
    	return $this->beLongsTo(Address::class);
    }

    public function scopeGetDayMn()
    {
        return Order::where('status', 'Thành công')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('status')->sum('amount');
    }

    public function scopeGetMonthMn()
    {
        return Order::where('status', 'Thành công')
            ->whereMonth('created_at', Carbon::today()->month)
            ->groupBy('status')->sum('amount');
    }

    public function scopeGetLastMonthMn()
    {
        return Order::where('status', 'Thành công')
            ->whereMonth('created_at', Carbon::today()->subMonth()->month)
            ->groupBy('status')->sum('amount');
    }

    public function scopeGetTotalMn()
    {
        return Order::where('status', 'Thành công')
            ->groupBy('status')->sum('amount');
    }

    public function scopeGetMn()
    {
        return Order::select('created_at', 'amount')->where('status', 'Thành công')
            ->whereRaw('extract(year from created_at) = extract(year from CURRENT_DATE)')
            ->get();
            // ->where(DB::raw("(DATE_FORMAT(created_at, '%Y'))"), date('Y'))
            // ->get();
    }

    public function setPaymentAttribute($value)
    {
        $this->attributes['payment'] = ($value == 1 ? 'Tiền mặt' : 'Chuyển khoản');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = floatval(str_replace(',', '', $value));
    }
}
