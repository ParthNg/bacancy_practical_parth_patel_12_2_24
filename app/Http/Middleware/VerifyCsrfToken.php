<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // 'customer_register'
        'signup',
        'get_variant_qty',
        'pincodes_auto_suggestion',
        'add_to_cart',
        'calculate_price_customization',
        'add_to_cart_own_pizza',
        'get_variant_qty',
        'get_total_qty_price_after_add_to_cart',
        'admin/orders/update_status',
        'admin/orders/cancel_order',
        'postcode_availability_check',
        'apply_voucher_code', 
        'callback',
        'admin/get_order_beep',
        

        
    ];
}
