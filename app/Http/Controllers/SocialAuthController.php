<?php

namespace App\Http\Controllers;

use App\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    protected $socialService;

    public function __construct(SocialAccountService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function redirect($driver)
    {
        return $this->socialService->redirectToProvider($driver);
    }

    public function callback($driver)
    {
        return $this->socialService->handleProviderCallback($driver);
    }
}
