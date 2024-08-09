<?php

namespace App\RepositoryDesignPattern;

use Exception;
use App\Models\User;
use App\Traits\ErrorLogs;
use App\RepositoryDesignPattern\BaseRepository;
use App\RepositoryDesignPattern\Interfaces\UserInterface;


class UserRepository extends BaseRepository implements UserInterface
{
    use ErrorLogs;
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function userListing($request){
        $per_page = $request->per_page ?? 1000;
        try {
            $data = $this->model->where('id', '!=', auth()->id())->paginate($per_page);
            return $data;
        } catch (Exception $e) {
            $this->error('Something went wrong please try again', 500);
            return $this->error_log($e);
        }
    }

    public function getUserDetails($id) {
        try {
            $userDetail = User::where('external_user_id', $id)->with('vehicles')->first();
            $data = [
                'userDetail' => $userDetail,
            ];

            return $data;
        } catch (Exception $e) {
            $this->error('Something went wrong please try again', 500);
            return $this->error_log($e);
        }
    }
}
