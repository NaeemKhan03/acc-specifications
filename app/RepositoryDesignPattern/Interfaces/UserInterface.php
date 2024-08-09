<?php

namespace App\RepositoryDesignPattern\Interfaces;

interface UserInterface extends BaseInterface
{
    public function userListing($request);
    public function getUserDetails($id);
}
