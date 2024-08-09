<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepositoryDesignPattern\Interfaces\VehicleSpecsValuesInterface;

class VehicleSpecsValuesController extends Controller
{
    private $vehicleSpecsValueRepo;
    public function __construct(VehicleSpecsValuesInterface $vehicleSpecsValueRepo)
    {
        $this->vehicleSpecsValueRepo = $vehicleSpecsValueRepo;
    }

    public function index(Request $request)
    {
        $specs = $this->vehicleSpecsValueRepo->vehicleSpecsValuesListing($request);
        return view('specs-values.index', compact('specs'));
    }

    public function specsSuggestion(Request $request)
    {
        return $this->vehicleSpecsValueRepo->specsSuggestion($request->all());
    }
}
