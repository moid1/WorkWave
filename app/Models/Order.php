<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded  = [];


    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manifest(){
        return $this->belongsTo(ManifestPDF::class,'id', 'order_id');
    }

    public function driver(){
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function fulfilled(){
        return $this->belongsTo(FullFillOrder::class,'id', 'order_id');
    }

    public function compared(){
        return $this->belongsTo(ManagerCompareOrder::class,'id', 'order_id');
    }

    public function tdfOrder(){
        return $this->belongsTo(TdfOrder::class ,'id', 'order_id');
    }
    public function trailerSwapOrder(){
        return $this->belongsTo(TrailerSwapOrder::class ,'id', 'order_id');
    }
}
