<?php

namespace App\RepositoryDesignPattern\Interfaces;

interface VehicleSpecsValuesInterface extends BaseInterface
{
    public function vehicleSpecsValuesListing($request);
    public function specsSuggestion($request);
}
