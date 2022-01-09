<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CognitoClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        // grab the credentials
        $username = $request->input('username');
        $password = $request->input('password');

        // attempt login
        $response = $client->login($username, $password);

        return $client->readResponse($response);
    }


    public function register(Request $request)
    {
        $client = new CognitoClient();

        // run validation rules as defined in conifg
        // see: https://laravel.com/docs/8.x/validation#conditionally-adding-rules

        Validator::make($request->all(), config('cognito.required_fields'));


        // cycle through all submitted data
        foreach(config('cognito.required_fields') as $field=>$validation)
        {
            // assign username and password when found
            if(in_array($field, ['username', 'password']))
            {
                $$field = $request->input($field);
                continue;
            }

            // put everything else into an attributes array
            $posted_fields[] = ['Name' => $field, 'Value' => $request->input($field)];
        }


        // fire these off to the client to attempt a registration
        $response = $client->register($username, $password, $posted_fields);

        if($response['error'] == false)
        {
            return redirect(route('confirm_signup', ['username' => $username]));
        }

        return false;
    }

    public function confirm_signup (Request $request)
    {
        $username = $request->input('username');
        $confirmation_code = $request->input('confirmation_code');

        $client = new CognitoClient();

        return $client->confirm_signup($username, $confirmation_code);

    }

    public function resend_confirmation_code (Request $request)
    {
        $username = $request->input('username');
        $client = new CognitoClient();
        $response = $client->resend_confirmation_code($username);
        if($response['error'] == false)
        {
            return redirect(route('confirm_signup', ['username' => $username]));
        }
    }
}
