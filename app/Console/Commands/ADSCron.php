<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Housing;
use App\Models\Order;
use Log;

class ADSCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ADS:active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle(): void
    {
        $orders = Order::where(['state' => 0, 'from' => '!=', null, 'to' => '!=', null])->get();
        foreach ($orders as $order) {
            if ($order->to <= now()) {
                $housing = Housing::whereId($order->housing_id)->first();
                if ($housing->category_id == [3, 4, 5, 7]) {
                    $housing->is_pay = 0;
                    $housing->save();
                    Log::info('Order ------>' . $order->id . ' is expired');
                    Log::info('Housing ------>' . $housing->id . ' change is_pay from 1 to 0');
                }
            }
        }
    }
}
