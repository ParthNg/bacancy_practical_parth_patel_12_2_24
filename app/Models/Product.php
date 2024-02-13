<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'sku', 'status'];

    /**
     * @return mixed
    */
    public function product_inventory()
    {
        return $this->hasMany('App\Models\Inventory','product_id','id' );
    }

}