<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CognitoClient;
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

        $username = $request->input('username');
        $password = $request->input('password');

        $response = $client->login($username, $password);

        return $client->readResponse($response);
    }
}
