<?php

namespace Harvouk\AwsCognitoLaravel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AwsCognitoController extends Controller
{
    //
    public function index()
    {
        return "Hello World";
    }

    //
    public function login(Request $request)
    {
        $client = new CognitoClient();

        $username = $request->input('email');
        $password = $request->input('password');

        $response = $client->login($username, $password);


        return $client->readResponse($response);


    }
}
