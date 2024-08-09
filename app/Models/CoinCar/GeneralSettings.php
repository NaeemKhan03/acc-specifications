<?php

namespace App\Models\CoinCar;

use App\Models\Specification\VehicleGeneralSpecs;
use App\Models\Specification\VehicleSpecsValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;
    protected $connection = 'coincars';
    protected $table = 'general_settings';
    protected $fillable = [
        'table_name',
        'field_name',
        'type',
        'name',
        'value',
        'source',
        'linked_id',
        'status',
        'extra',
    ];

    public function vehicleGeneralSpecs()
    {
        return $this->hasMany(VehicleGeneralSpecs::class, 'spec_category_id', 'id');
    }
    public function vehicleSpecsValues()
    {
        return $this->hasMany(VehicleSpecsValues::class, 'spec_category_id', 'id');
    }
}
