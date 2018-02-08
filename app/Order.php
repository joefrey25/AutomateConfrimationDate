<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    public function productOrders()
    {
        return DB::table('product_orders')
                ->select('orders.id', 'orders.customer_name', 'orders.billing_address', 'deliveries.delivery_date', DB::raw('group_concat(products.name) as products'), DB::raw('SUM(product_orders.total_quantity) as total_quantity'),  DB::raw('SUM(product_orders.total_price) as total_price'), 'orders.confirmation_date')
                ->join('orders', 'product_orders.order_id', '=', 'orders.id')
                ->join('products', 'product_orders.product_id', '=', 'products.id')
                ->leftJoin('deliveries', 'orders.id', '=', 'deliveries.order_id')
                ->groupBy('orders.id')
                ->get();
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_orders');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'product_orders');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
