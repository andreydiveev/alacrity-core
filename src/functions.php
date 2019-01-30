<?php

if (!function_exists('alacrity_url')) {
    /**
     * Appends the configured alacrity prefix and returns
     * the URL using the standard Laravel helpers.
     *
     * @param $path
     *
     * @param array $parameters
     * @param null $secure
     * @return string
     */
    function alacrity_url($path = null, $parameters = [], $secure = null)
    {
        $path = !$path || (substr($path, 0, 1) == '/') ? $path : '/'.$path;
        return url(config('alacrity.core.route_prefix', '').$path, $parameters, $secure);
    }
}

if (!function_exists('alacrity_authentication_column')) {
    /**
     * Return the username column name.
     * The Laravel default (and Alacrity default) is 'email'.
     *
     * @return string
     */
    function alacrity_authentication_column()
    {
        return config('alacrity.core.authentication_column', 'email');
    }
}

if (!function_exists('alacrity_auth')) {
    /*
     * Returns the user instance if it exists
     * of the currently authenticated user
     * based off the defined guard.
     */
    function alacrity_auth()
    {
        return \Auth::guard(alacrity_guard_name());
    }
}

if (!function_exists('alacrity_guard_name')) {
    /*
     * Returns the name of the guard defined
     * by the application config
     */
    function alacrity_guard_name()
    {
        return config('alacrity.core.guard', config('auth.defaults.guard'));
    }
}
