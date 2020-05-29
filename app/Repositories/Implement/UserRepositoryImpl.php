<?php

namespace App\Repositories\Implement;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Composer\Config;
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
            $user_email = $providerUser->getEmail();
            $user = User::whereEmail($user_email)->first();

            $user_name = $providerUser->getName();
            $user_avatar = $providerUser->getAvatar();
            // if user already found
            if ($user) {
                // update the avatar and provider that might have changed
                $user->update([
                    'name' => $user_name,
                    'avatar' => $user_avatar,
                    'access_token' => $providerUser->token,
                ]);
            } else {
                // create a new user
                // get admin email from config file
                $admin_email = config('adminEmail.email');

                if (in_array($user_email, $admin_email)) {
                    $roleId = 1; // role_id Admin
                } else {
                    $roleId = 3; // role_id User
                }

                $user = $this->getUser()::create([
                    'role_id' => $roleId,
                    'name' => $user_name,
                    'email' => $user_email,
                    'email_verified_at' => Carbon::now(),
                    'avatar' => $user_avatar,
                    'provider_name' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'access_token' => $providerUser->token,
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            return $e->getMessage();
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
                ->toJson();
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

    public function userStatistic()
    {
        try {
            $userStatistic = [];
            $userStatistic['all_users'] = $this->getUser()->count();
            $userStatistic['active_users'] = $this->getUser()->whereNull('deleted_at')->count();
            $userStatistic['top_users'] = $this->getUser()->withCount('posts')
                ->orderBy('posts_count', 'desc')->get();

            return $userStatistic;
        } catch (\Exception $e) {
            return $e->getMessage();
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
