<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class GeoPluginIP {
    static public function verify()
    {
        try {
            $client = new Client();
            $url = "https://www.geoplugin.net/json.gp?ip=".$_SERVER['REMOTE_ADDR'];

            $response = $client->request('GET', $url);

            return json_decode($response->getBody());
              
        } catch (IdentityProviderException $e) {
            // Failed to get the access token
            exit($e->getMessage());
        }
    }
}