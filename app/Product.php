<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use willvincent\Rateable\Rateable;
use Nicolaslopezj\Searchable\SearchableTrait;
use DB;

class Product extends Model
{
    use SoftDeletes, Rateable, SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.descript' => 5,
        ]
    ];

    protected $guarded = [];

    // lấy ra catalog của 1 product
    public function category() {
    	return $this->belongsTo(Category::class)->withTrashed();
    }
    
    // lấy ra các comment của product
    public function comments() {
    	return $this->hasMany(Comment::class);
    } 

    // lấy ra các order chứa product
    public function orders() {
    	return $this->belongsToMany(Orders::class, 'orders');
    }

    // lấy ra configuration của product
    public function configuration() {
    	return $this->hasOne(Configuration::class);
    }

    // lấy ra các image của product
    public function images() {
    	return $this->hasMany(Image::class);
    }

    // lấy ra orderDetail
    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }

    public function scopeGetProductDis($query)
    {
        return $query->where('discount', '>', 0);
    }

    public function scopeGetProductView($query)
    {
        return $query->latest('view');
    }

    public function scopeSeggest($query, $key, $id)
    {
        if ($id == 0)
            return $query->where('name', 'ilike', '%' . $key . '%');

        return $query->where('category_id', $id)->where('name', 'ilike', '%' . $key . '%');
    }

    public function scopeWhereCate($query, $id)
    {
        if ($id == 0)
            return $query;

        return $query->where('category_id', $id);
    }

    public function scopeSearchMul($query, $category_id, $price, $order)
    {
        switch ($price) {
            case 1:
                $query = $query->whereRaw('(price - discount) < 100000');
                break;

            case 2:
                $query = $query->whereRaw('(price - discount) >= 100000 and (price - discount) <= 300000');
                break;

            case 3:
                $query = $query->whereRaw('(price - discount) >= 300000 and (price - discount) <= 500000');
                break;

            case 4:
                $query = $query->whereRaw('(price - discount) > 500000');
                break;

            default:
                break;
        }
        if ($category_id == 0) {
            return $query->orderByRaw('price - discount ' . $order);
        }

        return $query->where('category_id', $category_id)->orderByRaw('price - discount ' . $order);
    }

    public function scopeGetProductNew($query)
    {
        return $query->latest();
    }

    public function scopeGetTopSell()
    {
        $temp = DB::table('products')
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->selectRaw('products.id, count(quantity) as total')
            ->where('orders.status', 'Thành công')
            ->whereNull('products.deleted_at')
            ->groupBy('products.id')
            ->latest('total')->get();
        $listId = array();
        foreach ($temp as $key => $value) {
            $listId[] = $value->id;
        }

        return Product::whereIn('id', $listId)->get();    
    }

    public function scopeGetAllCate()
    {
        $category = Category::all();
        $list = array();
        foreach ($category as $key => $value) {
            if ($value->parent_id == 0 && count($value->subCategory) > 0){
                foreach ($category as $key1 => $value1) {
                    if ($value1->parent_id == $value->id) {
                        $list[$value->name][$value1->id] = $value1->name;
                    }
                } 
            }else if ($value->parent_id == 0) {
                $list[$value->id] = $value->name; 
            }
        }
        return $list;
    }

    public function getFormatPriceAttribute()
    {
        return number_format($this->price - $this->discount);
    }

    public function scopeGetProductRe($query, $category_id, $id)
    {
        return $query->where('category_id', $category_id)->where('id', '<>', $id)->get();
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval(str_replace(',', '', $value));
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = floatval(str_replace(',', '', $value));
    }

    public function scopeGetProductSeg($query, $listCategoryId)
    {
        return $query->whereIn('category_id', $listCategoryId)
            ->orWhere('discount', '>', 0)->take(8)->get();
    }
}
