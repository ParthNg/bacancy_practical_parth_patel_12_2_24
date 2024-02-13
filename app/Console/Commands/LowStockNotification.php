<?php

namespace App\Console\Commands;
use App\Models\Product; 
use App\Models\Inventory; 
use App\Models\Setting; 
use App\Models\Notification; 

use Illuminate\Console\Command;
use DB;
use Hamcrest\Core\Set;
use Carbon\Carbon;
use App\Mail\InventoryNotification;
use Illuminate\Support\Facades\Mail;

class LowStockNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'low_stock_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Low Stock Notification';

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
        DB::beginTransaction();
            $short_quantity = (int)Setting::get('short_quantity');
            $days_before_notify_expiry = (int)Setting::get('days_before_notify_expiry');
            $inventoryRecords = Inventory::where('quantity', '>=', $short_quantity)
                ->whereDate('expiry_date', '<=', Carbon::now()->addDays($days_before_notify_expiry))
                ->get();
            if(count($inventoryRecords)) {
                Mail::to('parthpatel5510@gmail.com')->send(new InventoryNotification($inventoryRecords));
            }
        DB::commit();
        \Log::info('Command runnning: low_stock_notification');
        return 1;
    }
}
