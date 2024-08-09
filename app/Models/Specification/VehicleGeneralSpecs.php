<?php

namespace App\Models\Specification;

use App\Models\CoinCar\Vehicles;
use App\Models\CoinCar\GeneralSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleGeneralSpecs extends Model
{
    use HasFactory;
    protected $connection = 'specs';
    protected $table = 'vehicle_general_specs';
    protected $fillable = ['spec_category_id', 'vehicle_id', 'scrapped_spec_id', 'value'];

    public function scrappedSpecs()
    {
        return $this->belongsTo(ScrappedSpecs::class, 'scrapped_spec_id', 'id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(GeneralSettings::class, 'spec_category_id', 'id');
    }
}
