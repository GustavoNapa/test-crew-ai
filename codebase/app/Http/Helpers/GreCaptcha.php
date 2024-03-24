<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class GreCaptcha {
    static public function verify($key)
    {
        $captcha = isset($key) ? $key : null;
        if(is_null($captcha)){
            return [
                "status" => "ERROR",
                "message" => "Captcha não preenchido!"
            ];
        }
        $client = new Client();
        $secret = "6LcGqq8lAAAAAL4NEgmBImX9j2Nve_l-8FNi1f5a";
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

        $response = $client->request('POST', $url);

        $res = json_decode($response->getBody());
        if($res->success !== true){
            return [
                "status" => "ERROR",
                "message" => "Erro ao validar o captcha!!!"
            ];
        }else{
            return [
                "status" => "SUCCESS"
            ];
        }
    }
}