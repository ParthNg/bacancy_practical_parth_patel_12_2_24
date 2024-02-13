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
use App\Mail\OverallInventoryNotification;
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

            //Expiring lots in your inventory
            $inventoryRecords = Inventory::where('quantity', '>=', $short_quantity)
                ->whereDate('expiry_date', '<=', Carbon::now()->addDays($days_before_notify_expiry))
                ->get();
            if(count($inventoryRecords)) {
                Mail::to('parthpatel5510@gmail.com')->send(new InventoryNotification($inventoryRecords));
            }

            // Overall Inventory
            $products = Product::all();
            foreach ($products as $product) {
                // Retrieve all inventories for the current product
                $inventories = $product->product_inventory;

                // Array to store inventory status for the current product
                $inventoryStatus = [];

                // Iterate through each inventory
                foreach ($inventories as $inventory) {
                    $daysUntilExpiry = Carbon::now()->diffInDays($inventory->expiry_date, false);
                    $quantityStatus = ($inventory->quantity < $short_quantity) ? 'Low Quantity' : '';
                    $expiryStatus = ($daysUntilExpiry <= $days_before_notify_expiry && $daysUntilExpiry >= 0) ? 'Expiring Stock' : '';
                    $expiredStatus = (Carbon::now()->gt($inventory->expiry_date)) ? 'Expired' : '';
                    $finalStatus = $expiryStatus ?: ($expiredStatus ?: $quantityStatus ?: '');

                    // Add the inventory status to the array
                    $inventoryStatus[] = [
                        'lot_name' => $inventory->lot_name,
                        'quantity' => $inventory->quantity,
                        'expiry_date' => $inventory->expiry_date,
                        'status' => $finalStatus,
                    ];
                }

                // Add the inventory status array to the product
                $product->inventory_status = $inventoryStatus;
            }
            Mail::to('parthpatel5510@gmail.com')->send(new OverallInventoryNotification($products));
        DB::commit();
        \Log::info('Command runnning: low_stock_notification');
        return 1;
    }
}
