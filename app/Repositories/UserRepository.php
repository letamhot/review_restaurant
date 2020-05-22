<?php

namespace App\Repositories;

interface UserRepository extends BaseRepository
{
    // get information of User from Provider
    public function getUserInfo($provider);

    // create a new User or get info of User
    public function loginOrCreateUser($providerUser, $provider);

    // add Role value to JSON
    public function addRoleToJSON($id);
}
