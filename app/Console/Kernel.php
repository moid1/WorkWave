<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

        $schedule->call(function () {
            // Get all orders that are set to recur
            $recurringOrders = DB::table('orders')->where('is_recurring_order', true)->get();
            
            // Iterate through each recurring order
            foreach ($recurringOrders as $order) {
                // Calculate next month's date
                $nextMonthDate = Carbon::parse($order->delivery_date)->addMonth();
                $nextMonthEndDate = Carbon::parse($order->end_date)->addMonth();

                // Create a new order for next month
                Order::create([
                    'customer_id' => $order->customer_id,
                    'user_id' => $order->user_id,
                    'notes' => $order->notes,
                    'load_type' => $order->load_type,
                    'driver_id' => $order->driver_id,
                    'delivery_date' => $nextMonthDate,
                    'end_date' => $nextMonthEndDate,
                    'is_recurring_order' => true,
                ]);
            }
        })->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
