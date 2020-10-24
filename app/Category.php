<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeGetParentCate($query)
    {
        return $query->doesntHave('products')->where('parent_id', 0)->pluck('name', 'id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeGetSubCategory($query, $id)
    {
        return $query->where('parent_id', $id);
    }
    public function scopeGetSubCategoryId($query, $id)
    {
        return $query->where('parent_id', $id)->pluck('id')->toArray();
    }
}
