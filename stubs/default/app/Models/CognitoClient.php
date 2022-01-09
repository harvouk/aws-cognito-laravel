<?php

namespace App\Models;

use App\Models\CognitoJWT;

class CognitoClient extends CognitoJWT
{
    private $region;
    private $client_id;
    private $userpool_id;
    private $client;

    /*
     *  Much credit to https://sarangpatel.medium.com/aws-cognito-in-lumen-a14b5e869f46
     *  For the basis of this integration
     */

    public function __construct()
    {
        $cognitoConfig = [
            'credentials' => [
                'key' => config('cognito.credentials.key'),
                'secret' => config('cognito.credentials.secret')
            ],
            'region' =>  config('cognito.region'),
            'version' => config('cognito.version'),
            'app_client_id' => config('cognito.app_client_id') ,
            'app_client_secret' => config('cognito.app_client_secret'),
            'user_pool_id' => config('cognito.user_pool_id'),
        ];

        $aws = new \Aws\Sdk($cognitoConfig);
        $this->region = config('cognito.region');
        $this->client_id = config('cognito.app_client_id');
        $this->client_secret = config('cognito.app_client_secret');
        $this->userpool_id = config('cognito.user_pool_id');

        $this->client = $aws->createCognitoIdentityProvider();

    }


    public function cognitoSecretHash($username)
    {
        $hash = hash_hmac('sha256', $username . $this->client_id, $this->client_secret, true);
        return base64_encode($hash);
    }


    public function login(string $username, string $password)
    {
        $hash = $this->cognitoSecretHash($username);
        try
        {
            $result = $this
                ->client
                ->InitiateAuth([
                        'AuthFlow' => 'USER_PASSWORD_AUTH',
                        'ClientId' => $this->client_id,
                        'UserPoolId' => $this->userpool_id,
                        'AuthParameters' => [
                            'USERNAME' => $username,
                            'PASSWORD' => $password,
                            'SECRET_HASH' => $hash
                        ]
                    ]
                );

            $result = $result->toArray();

            if (isset($result['AuthenticationResult']))
            {
                return ['error' => false, 'message' => 'SUCCESS', 'data' => $result];
            }

        }
        catch(\Exception $e)
        {
            return ['error' => true, 'message' => $e->getMessage() ];
        }
    }


    public function register(string $username, string $email, string $password, string $phone_number)
    {
        try
        {
            $result = $this
                ->client
                ->signUp([
                        'ClientId' => $this->client_id,
                        'Username' => $username,
                        'Password' => $password,
                        'SecretHash' => $this->cognitoSecretHash($username) ,
                        'UserAttributes' => [
                            ['Name' => 'name', 'Value' => $username],
                            ['Name' => 'email', 'Value' => $email],
                            ['Name' => 'phone_number', 'Value' => $phone_number],
                        ]
                    ]
                );

            return ['error' => false, 'message' => 'SUCCESS', 'data' => $result];
        }
        catch(\Exception $e)
        {
            return ['error' => true, 'message' => $e->getMessage() ];
        }
    }


    public function logout($accessToken)
    {
        try
        {
            $response = $this
                ->client
                ->GlobalSignOut(['AccessToken' => $accessToken, ]);

            return ['error' => false, 'message' => 'SUCCESS', 'data' => $response->toArray() ];
        }
        catch(Exception $e)
        {
            return ['error' => true, 'message' => $e->getMessage() ];
        }
    }





}

