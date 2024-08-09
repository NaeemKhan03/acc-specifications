<?php

namespace App\Models\Specification;

use App\Models\CoinCar\Vehicles;
use App\Models\CoinCar\GeneralSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class VehicleSpecsValues extends Model
{
    use HasFactory;
    protected $connection = 'specs';
    protected $table = 'vehicle_specs_values';
    protected $fillable = [
        'spec_category_id',
        'vehicle_id', // one to many
        'scrapped_spec_id', // one to many
        'specs_value_id',
        'specs_value' // one to many
    ];

    public function category()
    {
        return $this->belongsTo(GeneralSettings::class, 'spec_category_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id', 'id');
    }

    public function scrappedSpecs()
    {
        return $this->belongsTo(ScrappedSpecs::class, 'scrapped_spec_id', 'id');
    }

    public function specsValues()
    {
        return $this->belongsTo(SpecsValues::class);
    }
}
