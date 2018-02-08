<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Delivery;
use App\Holiday;
use App\ProductOrder;

class OrdersController extends Controller
{

    public function index()
    {
        $order = new \App\Order;
        $orders = $order->productOrders();
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Confirme the confirm_date of the order
     *
     * @return string return the redirected URL
     */
    public function confirm(Request $request)
    {
        $order_id = $request->order_id;

        if (empty($order_id)) {
            return redirect('/orders');
        }
        
        $order = Order::find($order_id);
        if (!empty($order)) {
            $order->confirmation_date = date('Y-m-d');
            if($order->save()) {
                ProductOrder::where('order_id', $order_id)
                            ->update(['status' => 'confirmed']);
                return redirect()->route('/orders')->with('err_message', '');
            }
        }
        Session::flash('err_message', 'Empty order is not allowed');
        // return redirect()->route('/orders')->with('err_message', 'Empty order is not allowed');
        return redirect('/orders');
    }

    /**
     * This will handle manual confirmation of delivery date
     *
     * @return string  return the redirected URL string
     */
    public function confirmDelivery()
    {
        $order_id = request()->order_id;
        $delivery = new Delivery;
        $delivery->admin_id = 1;
        $delivery->order_id = $order_id;
        $delivery->delivery_date = $this->validateDelivery();
        
        if ($delivery->save()) {
            ProductOrder::where('order_id', $order_id)
                        ->update(['status' => 'delivered']);
            return redirect('/orders');
        }
        
    }

    /**
     * This function will validate the delivery date of an order and return it
     *
     * @param string $date              this param date will be used in schedule task/cron job 
     * @return string $delivery_date    this will return delivery date of an order
     */
    public function validateDelivery()
    {
        $holiday = new Holiday;
        $delivery_date_day = date('w', strtotime(date('Y-m-d')));
        $delivery_date = date('Y-m-d');

        switch ($delivery_date_day){ 
            case 5: // if this is friday
                $delivery_date = date('Y-m-d', strtotime($delivery_date . '+3 days'));
                break;
            case 6:
                $delivery_date = date('Y-m-d', strtotime($delivery_date . '+2 days'));
                break;
            case 7:
                $delivery_date = date('Y-m-d', strtotime($delivery_date . '+1 days'));
                break;
        }
        
        while (true) {
            if (!$holiday->isHoliday($delivery_date)) break; // if not holiday destroy infinite loop
            $delivery_date = date('Y-m-d', strtotime($delivery_date . '+ 1 day')); // if still it is holiday add 1 day to its delivery date
        }
        return $delivery_date;
    }
}
