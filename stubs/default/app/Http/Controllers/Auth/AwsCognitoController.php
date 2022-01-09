<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CognitoClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AwsCognitoController extends Controller
{

    /*
     *  Login
     */

    public function login_get(Request $request)
    {
        return view('auth.login', ['errors' => array(), 'request' => $request]);
    }

    //
    public function login_post(Request $request)
    {
        $client = new CognitoClient();

        // grab the credentials
        $username = $request->input('username');
        $password = $request->input('password');

        // attempt login
        $response = $client->login($username, $password);

        return $client->readResponse($response);
    }

    /*
     *  Register
     */

    public function register_get(Request $request)
    {
        return view('auth.register', ['errors' => array(), 'request' => $request]);
    }


    public function register_post(Request $request)
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
            $request->session()->put('username', $username);
            return redirect(route('confirm_signup', ['request' => $request]));
        }

        return false;
    }

    /*
     *  Confirm Sign-Up
     */

    public function confirm_signup_get (Request $request)
    {
        return view('auth.confirm_signup', ['errors' => array(), 'request' => $request]);
    }

    public function confirm_signup_post (Request $request)
    {
        $username = $request->input('username');
        $confirmation_code = $request->input('confirmation_code');

        $client = new CognitoClient();

        return $client->confirm_signup($username, $confirmation_code);

    }

    /*
     *  Resend Confirmation Code
     */

    public function resend_confirmation_code_get (Request $request)
    {
        return view('auth.resend_confirmation_code', ['errors' => array(), 'request' => $request]);
    }

    public function resend_confirmation_code_post (Request $request)
    {
        $username = $request->input('username');
        $client = new CognitoClient();
        $response = $client->resend_confirmation_code($username);
        if($response['error'] == false)
        {
            return redirect(route('confirm_signup', ['request' => $request]));
        }
    }

    /*
     *  Forgotten Password
     */

    public function forgotten_password_get (Request $request)
    {
        return view('auth.forgot_password', ['errors' => array(), 'request' => $request]);
    }

    public function forgotten_password_post (Request $request)
    {
        $username = $request->input('username');
        $client = new CognitoClient();
        $response = $client->forgotten_password($username);
        if($response['error'] == false)
        {
            $request->session()->put('username', $username);
            return redirect(route('forgot_password_confirm', ['request' => $request]));
        }
    }


    /*
     *  Forgotten Password
     */

    public function forgot_password_confirm_get (Request $request)
    {
        return view('auth.forgot_password_confirm', ['errors' => array(), 'request' => $request]);
    }

    public function forgot_password_confirm_post (Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $confirmation_code = $request->input('confirmation_code');

        $client = new CognitoClient();

        return $client->forgot_password_confirm($username, $password, $confirmation_code);
    }



    /*
     *  Get Devices
     */

    public function get_devices (Request $request)
    {
        //return $client->forgot_password_confirm($username, $password, $confirmation_code);
    }

}
