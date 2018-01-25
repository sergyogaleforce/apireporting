<?php

namespace App\Helpers;

use App\Entities\InfoLoginToReachLocal;
use Carbon\Carbon;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if (!function_exists('reachlocal_login')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function reachlocal_login($params)
    {
        //create client
        $client = new Client();

        try{
            //send request to reachlocal
            $result = $client->post(config('REACHLOCAL_API_URI')."/oauth/token", ['json' => $params]);
            //get response status
            $status = $result->getStatusCode();

            //ask if was the reponse was success (code: 200)
            if($status != 200){
                return response()->json(array(
                    'error' => $status,
                    'message' => $result->getBody()
                ));
            }
            //save login data from reachlocal
            $logininfo = new InfoLoginToReachLocal();
            $logininfo->access_token = $result['access_token'];
            $logininfo->refresh_token = $result['refresh_token'];
            $logininfo->save();

            //return login info in json
            return response()->json(array(
                'error' => "",
                'message' => $logininfo
            ));
        }
        catch (\GuzzleHttp\Exception\ServerException $exception){
            //return error
            return response()->json(array(
                'error' => 500,
                'message' => $exception->getMessage()
            ));
        }
    }
}

if (!function_exists('reachlocal_refresh_login')) {

    /**
     * description
     *
     * @param
     * @return
     */
        function reachlocal_refresh_login($params){

            $logininfo = InfoLoginToReachLocal::all();
            if($logininfo->count() > 0){
                //get login info (just one row in the table)
                $info = $logininfo->first();
                //get actual datetime
                $now = Carbon::now();
                //ask if the token expire in 10 minutes
                if($now->diffInMinutes($info->created_at) >= 10){
                    $client = new Client();
                    try{
                        //send request to reachlocal
                        $result = $client->post(config('REACHLOCAL_API_URI')."/oauth/token", ['json' => $params]);
                        //get response status
                        $status = $result->getStatusCode();

                        //ask if was the reponse wasnt success (code: 200)
                        if($status != 200){
                            return response()->json(array(
                                'error' => $status,
                                'message' => $result->getBody()
                            ));
                        }

                        //update the login info
                        $info->access_token = $result['access_token'];
                        $info->refresh_token = $result['refresh_token'];
                        $info->save();

                        //return login info in json
                        return response()->json(array(
                            'error' => "",
                            'message' => $logininfo
                        ));
                    }
                    catch (ServerException $exception){
                        //return error
                        return response()->json(array(
                            'error' => 500,
                            'message' => $exception->getMessage()
                        ));
                    }
                }else{
                    //return login info
                    return response()->json(array(
                        'error' => "",
                        'message' => $info
                    ));
                }
            }else{
                return response()->json(array(
                    'error' => 777,
                    'message' => "Require login info"
                ));
            }
        }
}

if (!function_exists('login')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function login($params)
    {
        $log_info = InfoLoginToReachLocal::all();
        if($log_info->count() == 0) {
            $log_info = $this->reachlocal_login(array(
                "client_id" => config("CLIENT_ID"),
                "client_secret" => config("CLIENT_SECRET"),
               // "code" => config("AUTHORIZATION_TOKEN"),
                "grant_type" => "password",
                "username" => config("USERNAME"),
                "password" => config("PASSWORD"),

                "redirect_uri" => config("REDIRECT_URI")
            ));
            $client = new Client();
            $params = array();
        }else {
            $log_info = $this->reachlocal_refresh_login(array(
                "client_id" => config("CLIENT_ID"),
                "client_secret" => config("CLIENT_SECRET"),
                "refresh_token" => $log_info->first()->refresh_token,
                "grant_type" => "refresh_token"
            ));
        }
        return $log_info;
    }
}



