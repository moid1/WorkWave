<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function driver(){
        return $this->belongsTo(User::class, 'driver_id')->with('truckDriver');
    }

    public function truck(){
return $this->belongsTo(Truck::class, 'truck_id');
    }
}
