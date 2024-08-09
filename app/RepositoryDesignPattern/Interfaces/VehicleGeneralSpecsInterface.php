<?php

namespace App\RepositoryDesignPattern\Interfaces;

interface VehicleGeneralSpecsInterface extends BaseInterface
{
    public function vehicleGeneralSpecsListing($request);
    public function scrappedSpecs($request);
    public function addVehicleGeneralSpecs($request, $vehicle_id);
    public function deleteVehicleGeneralSpecs($request);
    public function showGeneralSpecs($slug);
}
