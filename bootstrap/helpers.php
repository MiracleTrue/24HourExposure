<?php
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function get_client_ip()
{
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
    {

        $ip = getenv('HTTP_CLIENT_IP');

    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
    {

        $ip = getenv('HTTP_X_FORWARDED_FOR');

    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
    {

        $ip = getenv('REMOTE_ADDR');

    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
    {

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches [0] : '';
}

function is_wechat_browser()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
    {
        return true;
    } else
    {
        return false;
    }
}