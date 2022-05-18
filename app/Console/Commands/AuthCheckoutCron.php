<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shopper\Shopper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthCheckoutCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autocheckout:cron';

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
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
        $location_ids = DB::table('shoppers')->select('location_id')->groupBy('location_id')->get()->toArray();
        foreach ($location_ids as $value) {
            // update expire shopper status_id
            $time = Carbon::now()->subHour(2)->toDateTimeString();
            $expire_shopper = DB::table('shoppers')->where('status_id', '=', 1)->where('location_id', '=', $value->location_id)->where('check_in', '<=', $time)->orderBy('check_in', 'asc')->first();
            $expire_shopper = (array)$expire_shopper;
            if (count($expire_shopper)) {
                DB::table('shoppers')->where('id', '=', $expire_shopper['id'])->update(['status_id' => 2]);
            }

            // update next shopper status_id
            $next_shopper = DB::table('shoppers')->where('status_id', '=', 3)->where('location_id', '=', $value->location_id)->orderBy('check_in', 'asc')->first();
            $next_shopper = (array)$next_shopper;
            if (count($next_shopper)) {
                DB::table('shoppers')->where('id', '=', $next_shopper['id'])->update(['status_id' => 1]);
            }
        }
        return Command::SUCCESS;
    }
}
