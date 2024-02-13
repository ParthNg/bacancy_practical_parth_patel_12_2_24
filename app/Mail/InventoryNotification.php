<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InventoryNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $inventoryRecords;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inventoryRecords)
    {
        $this->inventoryRecords = $inventoryRecords;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.inventory_notification')
                    ->with('inventoryRecords', $this->inventoryRecords)
                    ->subject('Inventory Notification');
    }
}
