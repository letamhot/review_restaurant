<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

if (!function_exists('customDateFormat')) {
    function customDateFormat($value)
    {
        return  \Carbon\Carbon::parse($value)->format('F d, Y');
    }
}

// Default Cover image of Post
if (!function_exists('defaultPostImage')) {
    function defaultPostImage()
    {
        return  'http://res.cloudinary.com/phuonghoang/image/upload/v1588515341/posts/default_post_fkmbui.jpg';
    }
}

// Default User image
if (!function_exists('defaultUserImage')) {
    function defaultUserImage()
    {
        return  'http://res.cloudinary.com/phuonghoang/image/upload/v1588514190/profiles/default_user_dt79ye.png';
    }
}

// previous URL
if (!function_exists('intendedURL')) {
    function intendedURL()
    {
        if (!Session::has('pre_url')) {
            Session::put('pre_url', URL::previous());
        } else {
            if (URL::previous() != URL::to('login')) {
                Session::put('pre_url', URL::previous());
            }
        }
    }
}
