<?php

namespace App\Services;

class IPDetailsService
{
    public static function make()
    {
        return new static();
    }

    public function getIPDetails($ipAddress)
    {
        $json = file_get_contents("http://ipinfo.io/{$ipAddress}");
        $details = json_decode($json);
        return $details;
    }
}
