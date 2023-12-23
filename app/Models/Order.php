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
}
