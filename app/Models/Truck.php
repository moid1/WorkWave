<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function truckDriver(){
        return $this->belongsTo(TruckDriver::class,'id', 'truck_id')->with('user');
    }
}
