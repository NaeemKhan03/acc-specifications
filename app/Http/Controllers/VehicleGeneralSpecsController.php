<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\CreateGeneralSpecsRequest;
use App\Http\Requests\Vehicle\ScrappedSpecsRequest;
use App\RepositoryDesignPattern\VehicleGeneralSpecsRepository;
use Illuminate\Http\Request;

class VehicleGeneralSpecsController extends Controller
{
    private $vehicleGeneralSpecsRepo;

    public function __construct(VehicleGeneralSpecsRepository $vehicleGeneralSpecsRepo)
    {
        $this->vehicleGeneralSpecsRepo = $vehicleGeneralSpecsRepo;
    }

    public function index(Request $request)
    {
        $specs = $this->vehicleGeneralSpecsRepo->vehicleGeneralSpecsListing($request);
        return view('general-specs.index', compact('specs'));
    }
    /**
     * @OA\POST(
     *      path="/api/dealer/scrapped-specs",
     *      operationId="scrappedSpecsList",
     *      tags={"Scrapped Specs"},
     *      summary="get Scrapped Specs List",
     *      description="Returns list",
     *
     *      @OA\Parameter(
     *          name="specs",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          required=true,
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="error"
     *      )
     *     )
     */
    public function scrappedSpecsValues(ScrappedSpecsRequest $request)
    {
        return $this->vehicleGeneralSpecsRepo->scrappedSpecs($request);
    }
    /**
     * @OA\POST(
     *      path="/api/dealer/store-general-specs/{id}",
     *      operationId="Store Vehicle General Specs",
     *      tags={"Store Vehicle General Specs"},
     *      summary="to store Vehicle General Specs",
     *      description="store Vehicle General Specs",
     * 
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="scrapped_spec_id[]",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="specs_value[]",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="spec_category",
     *          in="query",
     *          required=true,
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="error"
     *      )
     *     )
     */
    public function storeVehicleGeneralSpecs(CreateGeneralSpecsRequest $request, $vehicle_id)
    {
        return $this->vehicleGeneralSpecsRepo->addVehicleGeneralSpecs($request, $vehicle_id);
    }
    /**
     * @OA\POST(
     *      path="/api/dealer/delete-vehicle-specs",
     *      operationId="DeleteVehicleSpecs",
     *      tags={"delete vehicle specs"},
     *      summary="delete vehicle specs",
     *      description="delete spec list",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="spec_category",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="error"
     *      )
     *     )
     */
    public function deleteVehicleGeneralSpecs(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'spec_category' => 'required|string',
        ]);
        return $this->vehicleGeneralSpecsRepo->deleteVehicleGeneralSpecs($request);
    }
    /**
     * @OA\GET(
     *      path="/api/show-specs/{slug}",
     *      operationId="Show specs",
     *      tags={"Show vehicle specs"},
     *      summary="Show vehicle specs",
     *      description="Show spec list",
     *
     *      @OA\Parameter(
     *          name="slug",
     *          in="path",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="error"
     *      )
     *     )
     */
    public function showGeneralSpecs($slug)
    {
        return $this->vehicleGeneralSpecsRepo->showGeneralSpecs($slug);
    }
}
