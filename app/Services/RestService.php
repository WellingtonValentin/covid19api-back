<?php

namespace App\Services;

class RestService
{
    private $restEndpoint = '';

    /**
     * RestService constructor.
     */
    public function __construct()
    {
        $this->restEndpoint = env('REST_URL');
    }


    public function getResults(): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->restEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);

        return json_decode($return, true);
    }
}
