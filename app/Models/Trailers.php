<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trailers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerData(){
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }
}
