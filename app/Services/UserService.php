<?php

namespace App\Services;

interface UserService extends BaseService
{
    // get information of User from Provider
    public function getUserInfo($provider);

    // create a new User or get info of User
    public function loginOrCreateUser($providerUser, $provider);

    // Get information of User along with all Role for edit mode.
    public function findByIdWithTrashedToEdit($id);
}
