<?php

// Username of Auth
if (! function_exists('username')) {

    function username()
    {
        return auth()->user()->name;
    }
}

// ID of Auth

if (! function_exists('id')) {

    function id()
    {
        return auth()->user()->id;
    }
}

// Email of Auth

if (! function_exists('email')) {

    function email()
    {
        return auth()->user()->email;
    }
}

// Password of Auth

if (! function_exists('pass')) {

    function pass()
    {
        return auth()->user()->pass;
    }
}

