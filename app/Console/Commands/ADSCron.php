<?php

namespace App\Console\Commands;

use Carbon\Carbon;
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
        try {
            $orders = Order::all();
            foreach ($orders as $order) {
                if ($order->to == Carbon::now()->format('Y-n-j')) {
                    $housing = Housing::whereId($order->housings_id)->first();
                    if ($housing->is_pay == 1) {
                        $housing->is_pay = 0;
                        $housing->save();
                        $order->status = 1;
                        Log::info('----------------Start ADS:active--------------------');
                        Log::info('Order ------>' . $order->id . ' is expired');
                        Log::info('----------------End ADS:active--------------------');
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('----------------Start ADS:active--------------------');
            Log::error($e->getMessage());
            Log::info('----------------End ADS:active--------------------');
        }
    }
}
