<?php

namespace App\Models;

use Firebase\JWT\JWT;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

class CognitoJWT extends CognitoIdentityProviderClient
{

    public static function readResponse ($cognito_response)
    {
        if($cognito_response['error'] == true)
        {
            return $cognito_response['message'];
        }

        $access_token = !empty($cognito_response['data']['AuthenticationResult']['AccessToken']) ? $cognito_response['data']['AuthenticationResult']['AccessToken'] : '';
        $refresh_token = !empty($cognito_response['data']['AuthenticationResult']['RefreshToken']) ? $cognito_response['data']['AuthenticationResult']['RefreshToken'] : '';
        $id_token = !empty($cognito_response['data']['AuthenticationResult']['IdToken']) ? $cognito_response['data']['AuthenticationResult']['IdToken'] : '';

        return [
            'error' => $cognito_response['error'],
            'message' => $cognito_response['message'],
            'id_token' => static::verifyToken($id_token),
            'expiry_period' => $cognito_response['data']['AuthenticationResult']['ExpiresIn'],
            'refresh_token' => $refresh_token,
            'access_token' => $access_token,
            //'access_token' => $this->verifyToken($access_token),
            'device' => $cognito_response['data']['AuthenticationResult']['NewDeviceMetadata'],
            'served_by' => config('app.name'),
            'served' => date("Y-m-d H:i:s")
        ];
    }

    public static function verifyToken(string $jwt)
    {
        $publicKey = null;
        $kid = static::getKid($jwt);
        if ($kid) {
            $row = static::getPublicKey($kid);
            if ($row) {
                $publicKey = $row;
            }
        }

        if ($publicKey) {
            try{
                return JWT::decode($jwt,
                    $publicKey, array('RS256'));
            }catch(\Exception $e){
                return ['error' => true, 'message' => $e->getMessage() ];
            }
        }
        return null;
    }


    public static function getPublicKey(string $kid): ?string
    {
        $jwksUrl =  sprintf(config('cognito.idp_endpoint'), config('cognito.region'), config('cognito.user_pool_id'));

        $ch = curl_init($jwksUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 3,
        ]);
        $jwks = curl_exec($ch);
        if ($jwks) {
            $json = json_decode($jwks, false);
            if ($json && isset($json->keys) &&
                is_array($json->keys)) {
                foreach ($json->keys as $jwk) {
                    if ($jwk->kid === $kid) {
                        return static::jwkToPem($jwk);
                    }
                }
            }
        }
        return null;
    }

    public static function jwkToPem(object $jwk): ?string
    {
        if (isset($jwk->e) && isset($jwk->n)) {
            $rsa = new RSA();
            $rsa->loadKey([
                'e' => new BigInteger(
                    JWT::urlsafeB64Decode($jwk->e), 256),
                'n' => new BigInteger(
                    JWT::urlsafeB64Decode($jwk->n),  256)
            ]);
            return $rsa->getPublicKey();
        }
        return null;
    }


    public static function getKid(string $jwt): ?string
    {
        $tks = explode('.', $jwt);
        if (count($tks) === 3) {
            $header =
                JWT::jsonDecode(JWT::urlsafeB64Decode($tks[0]));
            if (isset($header->kid)) {
                return $header->kid;
            }
        }
        return null;
    }

}
