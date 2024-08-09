<?php

namespace App\Models\CoinCar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Specification\VehicleSpecsValues;
use App\Models\Specification\VehicleGeneralSpecs;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicles extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection="coincars";
    
    public function generalVehicleSpecs()
    {
        return $this->hasMany(VehicleGeneralSpecs::class,'vehicle_id');
    }

    public function vehicleSpecValues()
    {
        return $this->hasMany(VehicleSpecsValues::class,'vehicle_id');
    }
}
