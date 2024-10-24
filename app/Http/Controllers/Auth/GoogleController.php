<?php

namespace App\Http\Controllers\Auth;


class GoogleController extends OAuthController
{
    const DRIVER = 'google';
    const NETWORK_ID_FIELD = 'google_id';
}

