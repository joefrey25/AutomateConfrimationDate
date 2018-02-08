<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Order', 'orders');
    }

    public function scopeGetAvailableProducts($query)
    {
        return $query->where('status', 0);
    }
}
