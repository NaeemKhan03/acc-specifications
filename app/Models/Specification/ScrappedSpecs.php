<?php

namespace App\Models\Specification;

use App\Models\CoinCar\GeneralSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrappedSpecs extends Model
{
    use HasFactory;
    protected $connection = 'specs';
    protected $fillable = [
        'label', 'category_id', 'user_id', 'last_used', 'unit', 'status'
    ];

    public function generalScrappedSpecs()
    {
        return $this->hasMany(VehicleGeneralSpecs::class, 'scrapped_spec_id', 'id');
    }
    public function scrappedSpecsValues()
    {
        return $this->hasMany(VehicleSpecsValues::class, 'scrapped_spec_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(GeneralSettings::class, 'spec_category_id', 'id');
    }
}
