<!-- resources/views/emails/inventory_notification.blade.php -->

<p>Hello,</p>

<p>The following inventory items require attention:</p>

@foreach($inventoryRecords as $record)
    <p>Product: {{ $record->product->name }}, Lot: {{ $record->lot_name }}, Expiry Date: {{ $record->expiry_date }}</p>
@endforeach

<p>Thank you.</p>
