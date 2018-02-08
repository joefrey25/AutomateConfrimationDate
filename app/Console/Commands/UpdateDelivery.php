<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Delivery;
use App\Holiday;

class UpdateDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDelivery:confirmdelivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating date deliveries...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // This will get all deliveries for certain day and will update the delivery date base on the rules given for the business
        $orders = DB::table('orders')->where('confirmation_date', 'LIKE', date('Y-m') . '%')->get();
        $order_ids = [];
        foreach ($orders as $order) {
            $delivery = Delivery::updateOrCreate(
                ['order_id' => $order->id],
                ['delivery_date' => $this->validateDelivery()]
            );
        }
        echo "Update Successfully!\n";
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
