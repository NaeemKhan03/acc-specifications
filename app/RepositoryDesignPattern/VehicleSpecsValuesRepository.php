<?php

namespace App\RepositoryDesignPattern;

use App\RepositoryDesignPattern\BaseRepository;
use App\Models\Specification\VehicleSpecsValues;
use App\Models\Specification\VehicleGeneralSpecs;
use App\RepositoryDesignPattern\Interfaces\VehicleSpecsValuesInterface;
use App\Traits\ErrorLogs;

use Exception;

class VehicleSpecsValuesRepository extends BaseRepository implements VehicleSpecsValuesInterface
{
    use ErrorLogs;
    protected $model;

    public function __construct(VehicleSpecsValues $model)
    {
        $this->model = $model;
    }

    public function vehicleSpecsValuesListing($request)
    {
        $per_page = $request->per_page ?? 1000;
        try {
            $data = $this->model->paginate($per_page);
            return $data;
        } catch (Exception $e) {
            return $this->error_log($e);
        }
    }

    public function specsSuggestion($request)
    {
        try {
            $make_id = $request['make_id'] ?? null;
            $model_id = $request['model_id'] ?? null;
            $body_type_id = $request['body_type_id'] ?? null;

            if (isset($request['category_id']) && ($request['category_id'] == 89 || $request['category_id'] == 90)) {
                $specifications = VehicleGeneralSpecs::query();
            } else {
                $specifications = $this->model->query();
            }

            $specifications = $specifications->when(isset($request['category_id']) && !is_null($request['category_id']), function ($q) use ($request) {
                return $q->where('spec_category_id', $request['category_id']);
            });
            $specifications = $specifications->with(['scrappedSpecs:id,label', 'vehicle' => function ($query) use ($make_id, $model_id, $body_type_id) {
                $query->select('id', 'make_id', 'model_id', 'body_type_id');
                $query->when(!is_null($make_id), function ($q) use ($make_id) {
                    return $q->where('make_id', '=', $make_id);
                });
                $query->when(!is_null($model_id), function ($q) use ($model_id) {
                    return $q->where('model_id', '=', $model_id);
                });
                $query->when(!is_null($body_type_id), function ($q) use ($body_type_id) {
                    return $q->where('body_type_id', '=', $body_type_id);
                });
            }]);

            $specifications = $specifications->groupBy('scrapped_spec_id')->get();
            return $this->success('Specification suggestion', $specifications, 200);
        } catch (Exception $e) {
            return $this->error_log($e);
        }
    }
}
