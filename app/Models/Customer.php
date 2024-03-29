<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function notes(){
        return $this->hasMany(Notes::class, 'customer_id')->where('title', 'Order Note')->latest();
    }

     public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
