<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class ProcessRecurringOrders extends Command
{
    protected $signature = 'orders:process-recurring';
    protected $description = 'Process recurring orders and create new ones based on their next scheduled time.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch orders where `is_recurring_order` is true and `next_time_order` is due
        // $orders = Order::where('is_recurring_order', true)
        //                 ->whereDate('next_time_order', '<=', Carbon::today())
        //                 ->orWhere('next_time_order', null)
        //                 ->get();

        // foreach ($orders as $order) {
        //     $this->createRecurringOrder($order);
        // }

        $this->info('Recurring orders processed.');
    }

    protected function createRecurringOrder($order)
    {
        $frequency = $order->frequency; // Frequency in days
    
        // Calculate the next delivery date and update next_time_order
        $nextDeliveryDate = Carbon::parse($order->next_time_order)->addDays($frequency);
    
        // Create new order with updated details
        Order::create([
            'customer_id' => $order->customer_id,
            'user_id' => $order->user_id,
            'notes' => $order->notes,
            'load_type' => $order->load_type,
            'truck_id' => $order->truck_id,
            'delivery_date' => $nextDeliveryDate,
            'end_date' => $order->end_date, // Update end_date if needed
            'is_recurring_order' => true,
            'estimated_tires' => $order->estimated_tires,
            'frequency' => $order->frequency,
            'next_time_order' => $nextDeliveryDate->addDays($frequency), // Update next_time_order for the next cycle
        ]);
    }
}
