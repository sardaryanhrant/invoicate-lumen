<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function register(Request $request){
//        $request->validate([
//            'email' => 'required',
//            'password' => 'required'
//        ]);
        $user=new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->city = $request->city;
        $user->postcode = $request->postcode;
        $user->company_name = $request->company_name;
        $user->website = $request->website;
        $user->tax_code = $request->tax_code;
        $user->business_name = $request->business_name;
        $user->password = Hash::make($request->getPassword);
        $user->save();

        $http = new Client;

        $response = $http->post(url('oauth/token'),[
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'pGjQ8jqZzebmz4EawcOxqwnuVx3I6mQ2ZBtLA4h5',
                'email' => $request->email,
                'password' => $request->password,
                'scope' => ''
            ]
        ]);

        return response(['data' => json_decode((string) $response->getBody(), true)]);
    }

    public function login(Request $request){
//        $request->validate([
//            'email' => 'required',
//            'password' => 'required'
//        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response(['status' => 'error', 'message'=>'User not found']);
        }

//        if(Hash::check((string) $request->password, $user->password)){
            $http = new Client;

            $response = $http->post(url('oauth/token'),[
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'pGjQ8jqZzebmz4EawcOxqwnuVx3I6mQ2ZBtLA4h5',
                    'email' => $request->email,
                    'password' => $request->password,
                    'scope' => ''
                ]
            ]);

            return response(['data' => json_decode((string) $response->getBody(), true)]);
//        } else {
//
//            return $user->password;
//        }

    }
}
