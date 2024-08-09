<?php

namespace App\Http\Controllers;

use App\RepositoryDesignPattern\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $users = $this->userRepository->userListing($request);
        return view('users.index', compact('users'));
    }

    public function userDetails($id)
    {
        $users = $this->userRepository->getUserDetails($id);

        return view('users.userDetails', [
            'userDetail' => $users['userDetail'],
            'userPayments' => $users['userPayment'],
        ]);
    }
}
