<?php

namespace App\RepositoryDesignPattern;

use Exception;
use App\Traits\ErrorLogs;
use Illuminate\Support\Facades\DB;
use App\Models\CoinCar\GeneralSettings;
use App\Models\Specification\ScrappedSpecs;
use App\RepositoryDesignPattern\BaseRepository;
use App\Models\Specification\VehicleSpecsValues;
use App\Models\Specification\VehicleGeneralSpecs;
use App\RepositoryDesignPattern\Interfaces\VehicleGeneralSpecsInterface;


class VehicleGeneralSpecsRepository extends BaseRepository implements VehicleGeneralSpecsInterface
{
    use ErrorLogs;
    protected $model;

    public function __construct(VehicleGeneralSpecs $model)
    {
        $this->model = $model;
    }

    public function vehicleGeneralSpecsListing($request)
    {
        $per_page = $request->per_page ?? 10;
        try {
            $data = $this->model->paginate($per_page);
            return $data;
        } catch (Exception $e) {
            $this->error('Something went wrong please try again', 500);
            return $this->error_log($e);
        }
    }

    public function scrappedSpecs($request)
    {
        $data = array();
        try {
            $data['scrapped_specs'] = ScrappedSpecs::where('category_id', $request->category_id)->where('label', 'Like', '%' . $request->specs . '%')->get();
            if ($data['scrapped_specs']) {
                return $this->success('Specs List', $data, 200);
            } else {
                return $this->error("Error: Specs not found", 404);
            }
        } catch (Exception $e) {
            $this->error_log($e);
            return $this->error($e, 500);
        }
    }

    public function addVehicleGeneralSpecs($request, $vehicle_id)
    {
        try {
            $category = GeneralSettings::where('id', $request->spec_category)->where('field_name', 'category')->where('table_name', 'specifications')->first();
            if ($category) {
                DB::beginTransaction();
                foreach ($request->scrapped_spec_id as $key => $scrapped_spec_id) {
                    if ($request->spec_category == 89 || $request->spec_category == 90) {
                        $request->validate([
                            'specs_value' => 'required|array',
                            'specs_value.*' => 'required|string',
                        ]);
                        $specs = [
                            'spec_category_id' => $request->spec_category,
                            'vehicle_id' => $vehicle_id,
                            'scrapped_spec_id' => $scrapped_spec_id,
                            'specs_value' => $request->specs_value[$key],
                        ];
                        VehicleSpecsValues::updateOrCreate(
                            ['vehicle_id' => $specs['vehicle_id'], 'scrapped_spec_id' => $specs['scrapped_spec_id']],
                            $specs
                        );
                    } else {
                        $specs = [
                            'scrapped_spec_id' => $scrapped_spec_id,
                            'value' => $request->specs_value[$key] ?? "",
                            'spec_category_id' => $request->spec_category,
                            'vehicle_id' => $vehicle_id
                        ];
                        VehicleGeneralSpecs::updateOrCreate(
                            ['vehicle_id' => $specs['vehicle_id'], 'scrapped_spec_id' => $specs['scrapped_spec_id']],
                            $specs
                        );
                    }
                }
                DB::commit();
                return $this->success("Specs Created Successfully", "", 200);
            } else {
                return $this->error("Error: Invalid Category Id", 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error_log($e);
        }
    }

    public function deleteVehicleGeneralSpecs($request)
    {


        return $request->user();
        try {
            if ($request->spec_category == 89 || $request->spec_category == 90) {
                $delete = VehicleSpecsValues::whereRelation('vehicle', 'user_id', $user->id)->where('id', $request->id)->delete();
            } else {
                $delete = VehicleGeneralSpecs::whereRelation('vehicle', 'user_id', $user->id)->where('id', $request->id)->delete();
            }
            if ($delete) {
                return $this->success("Spec Deleted Successfully", "", 200);
            } else {
                return $this->error("Error: Spec not found", 404);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error_log($e);
        }
    }

    public function showGeneralSpecs($slug)
    {
        $slug_arr = explode('-', $slug);
        $id = last($slug_arr);
        // $result = array();
        if (!is_numeric($id)) {
            return $this->error("Vehicle Does Not Exist", 404);
        }
        $result = GeneralSettings::select('id', 'name')->with(['vehicleGeneralSpecs' => function ($query) use ($id) {
            $query->with('scrappedSpecs')->where('vehicle_id', $id);
        }])->with(['vehicleSpecsValues' => function ($query) use ($id) {
            $query->with('scrappedSpecs')->where('vehicle_id', $id);
        }])->where('field_name', 'category')->where('table_name', 'specifications')
            ->get();
        // $result = VehicleGeneralSpecs::with('category')->where('vehicle_id', $id)->get();
        // ScrappedSpecs::whereIn('category_id',$result)where
        // $vehicleSpecs =   VehicleSpecsValues::select('spec_category_id', 'specs_value', 'scrapped_specs.id', 'scrapped_specs.label', 'scrapped_specs.category_id')
        //     ->where('vehicle_id', $id)
        //     ->join('scrapped_specs', 'vehicle_specs_values.scrapped_spec_id', '=', 'scrapped_specs.id')
        //     ->distinct('scrapped_specs.label')
        //     ->get();
        // $vehicleSpecs2 = VehicleGeneralSpecs::select('spec_category_id', 'value', 'scrapped_specs.id', 'scrapped_specs.label', 'scrapped_specs.category_id')
        //     ->where('vehicle_id', $id)
        //     ->join('scrapped_specs', 'vehicle_general_specs.scrapped_spec_id', '=', 'scrapped_specs.id')
        //     ->distinct('scrapped_specs.label')
        //     ->get();
        // $categories = GeneralSettings::where('field_name', 'category')->where('table_name', 'specifications')->get();
        // foreach ($categories as $category) {
        //     $result[str_replace(' ', '_', $category->name)] = array();
        // }
        // if (!empty($vehicleSpecs) && count($vehicleSpecs) !== 0) {
        //     $vehicleSpecs = json_decode(json_encode($vehicleSpecs), true);
        //     $key = 'spec_category_id';
        //     foreach ($vehicleSpecs as $val) {
        //         if (array_key_exists($key, $val)) {
        //             $result[$val[$key]][] = $val;
        //         }
        //     }
        // }
        // if (!empty($vehicleSpecs2) && count($vehicleSpecs2) !== 0) {
        //     $vehicleSpecs2 = json_decode(json_encode($vehicleSpecs2), true);
        //     $key = 'spec_category';
        //     foreach ($vehicleSpecs2 as $val) {
        //         if (array_key_exists($key, $val)) {
        //             $result[$val[$key]][] = $val;
        //         }
        //     }
        // }
        if ($result) {
            return $this->success("Specs List",  $result, 200);
        } else {
            return $this->error("Specs Does Not Exist", 404);
        }
    }
}
