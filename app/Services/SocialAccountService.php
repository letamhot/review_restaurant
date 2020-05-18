<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountService
{
    // list all supported providers
    protected $providers = [
        'facebook', 'google',
    ];

    protected $modelRepository;

    public function __construct(UserRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    // check support provider
    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            // get previous URL - function from Helper class
            intendedURL();

            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            return $this->sendFailedResponse();
        }
    }

    // get info of user from API providers
    public function handleProviderCallback($driver)
    {
        try {
            $user = $this->modelRepository->getUserInfo($driver);
        } catch (\Exception $e) {
            return $this->sendFailedResponse('Something went wrong!');
        }

        return $this->loginOrCreateAccount($user, $driver);
    }

    // check if user is exist or create a new one and login
    public function loginOrCreateAccount(ProviderUser $providerUser, $provider)
    {
        try {
            $user = $this->modelRepository->loginOrCreateUser($providerUser, $provider);

            Auth::login($user, true);

            return $this->sendSuccessResponse();
        } catch (\Exception $e) {
            return $this->sendFailedResponse('Something went wrong!');
        }
    }

    // redirect to previous URL or specific intended URL
    protected function sendSuccessResponse()
    {
        // return redirect('/dashboard');
        return redirect(Session::get('pre_url'));
    }

    // notify for user about error information
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->with('error', $msg ?: 'Unable to login, try with another provider to login.')
        ;
    }

    // compare input driver to supported driver list
    protected function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
