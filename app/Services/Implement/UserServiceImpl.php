<?php

namespace App\Services\Implement;

use App\Repositories\UserRepository;
use App\Services\UserService;

class UserServiceImpl extends BaseServiceImpl implements UserService
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return UserRepository::class;
    }

    // get information of User from Provider
    public function getUserInfo($provider)
    {
        return $this->makeRepo()->getUserInfo($provider);
    }

    // create a new User or get info of User
    public function loginOrCreateUser($providerUser, $provider)
    {
        return $this->makeRepo()->loginOrCreateUser($providerUser, $provider);
    }

    // Get information of User along with all Role for edit mode.
    public function findByIdWithTrashedToEdit($id)
    {
        return $this->makeRepo()->addRoleToJSON($id);
    }

    /**
     * Make Model Class.
     */
    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }
}
