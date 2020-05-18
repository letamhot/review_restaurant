<?php

namespace App\Repositories\Implement;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Yajra\DataTables\DataTables;

class UserRepositoryImpl extends EloquentRepository implements UserRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    // OAuth Login - get information of User from Provider
    public function getUserInfo($driver)
    {
        try {
            return Socialite::driver($driver)->stateless()->user();
        } catch (\Exception $e) {
            return null;
        }
    }

    // OAuth Login - create a new User or get info of User
    public function loginOrCreateUser($providerUser, $provider)
    {
        try {
            // check for already has account
            $user = User::whereEmail($providerUser->getEmail())->first();

            // if user already found
            if ($user) {
                // update the avatar and provider that might have changed
                $user->update([
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'access_token' => $providerUser->token,
                ]);
            } else {
                // create a new user
                $user = $this->getUser()->create([
                    // 'role_id' => '3', // regular user
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'email_verified_at' => Carbon::now(),
                    'avatar' => $providerUser->getAvatar(),
                    'provider_name' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'access_token' => $providerUser->token,
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Override method getAll() function for dataTable AJAX.
     * Using for UserController@index.
     */
    public function getAll()
    {
        try {
            $data = $this->getUser()::select('id', 'role_id', 'name', 'email', 'status', 'provider_name', 'created_at', 'updated_at', 'deleted_at')->withTrashed();
            $inactive = $this->getUser()::select('id')->onlyTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($data) {
                    return $data->count();
                })
                ->with('inactive_count', function () use ($inactive) {
                    return $inactive->count();
                })
                ->addColumn('role_name', function ($data) {
                    return $data->role_name;
                })
                ->addIndexColumn()
                ->toJson()
            ;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Return information of User along with all Role for edit mode.
     *
     * @param mixed $id
     */
    public function addRoleToJSON($id)
    {
        try {
            $user = $this->findByIdWithTrashed($id)->toArray();
            $user['role'] = Role::select('id', 'name')->get();

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Make Model class.
     */
    protected function getUser()
    {
        return app()->make($this->getModel());
    }
}
