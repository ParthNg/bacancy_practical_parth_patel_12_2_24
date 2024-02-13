<!-- resources/views/emails/inventory_notification.blade.php -->

<p>Hello,</p>

<p>This is the Overall Inventory:</p>

@foreach($inventoryRecords as $product) 
              <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->sku}}</td>
                <td>
                  <div>
                    <table>
                    @foreach($product->inventory_status  as $inv)
                      <tr>
                        <td>
                          Lot: {{$inv['lot_name']}}<br/>
                          Quantity: {{$inv['quantity']}}<br/>
                          Expiry Date: {{$inv['expiry_date']}}<br/>
                          Status: {{$inv['status']}}<br/>
                          <hr/>
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </div>
                </td>
              </tr>
            @endforeach

<p>Thank you.</p>
