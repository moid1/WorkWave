<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesktopManifest extends Model
{
    protected $fillable = [
        'type_of_passenger',
        'type_of_agri_tyre',
        'type_of_truck_tyre',
        'type_of_other',
        'order_id',
        'processor_reg_no',
        'customer_signature',
        'driver_signature',
        'cheque_no',
        'left_over',
        'radialStuff',
    ];

    protected $casts = [
        'type_of_passenger' => 'array',
        'type_of_agri_tyre' => 'array',
        'type_of_truck_tyre' => 'array',
        'type_of_other' => 'array',
        'radialStuff' => 'array',
    ];

    // Optional: alias id as manifest_id
    public function getManifestIdAttribute()
    {
        return $this->id;
    }
}
