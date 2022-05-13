<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Orderdetail extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'orderdetails';

    protected $guarded = [];

    protected $casts = [
        'id'                => 'integer',
        'product_id'           => 'integer',
        'order_id'             => 'integer',
        'quantity'       => 'integer',
        'product_price'     => 'integer',
        'product_total_price'    => 'integer',
    ];

    public function Product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function Order(){
        return $this->belongsTo(Order::class,'order_id');
    }

    //scope
    public function scopeFinished($query, $id)
    {
        return $query->whereHas('Order' , function($q){
                                $q->where('status', 2);
                            })->whereHas('Product', function($q) use($id){
                                $q->where('vendor_id', $id);
                            });
    }

    public function scopeReturned($query, $id)
    {
        return $query->whereHas('Order' , function($q){
                                $q->where('status', 3);
                            })->whereHas('Product', function($q) use($id){
                                $q->where('vendor_id', $id);
                            });
    }
}
