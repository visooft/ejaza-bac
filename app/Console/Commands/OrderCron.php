<?php

namespace App\Console\Commands;

use App\Models\Housing;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class OrderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passenger:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Passenger order cron';

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
     * @return int
     */
    public function handle(): void
    {
        try {
            $order = Order::where('expiried', '!=', null)->get();
            foreach ($order as $item) {
                if ($item->expiried <= Carbon::now()->format('Y-m-d H:i')) {
                    $housing = Housing::whereId($item->housings_id)->first();
                    if ($housing->is_pay == 1) {
                        $housing->is_pay = 0;
                        $housing->save();
                        $item->status = 1;
                        $item->save();
                        Log::info('----------------Start passenger:order--------------------');
                        Log::info('Order ------>' . $item->id . ' is expired');
                        Log::info('----------------End passenger:order--------------------');

                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('----------------Start passenger:order--------------------');
            Log::error($e->getMessage());
            Log::error('----------------End passenger:order--------------------');
        }
    }
}
