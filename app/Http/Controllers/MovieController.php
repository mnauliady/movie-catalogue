<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MovieController extends Controller
{
    //
    public $base_url = "https://api.themoviedb.org/3/";
    public $api_key = "Change to your api key from themoviedb";
    
    public function apiWithKey()
    {
         
        $client = new Client();
        $url = "$this->base_url/movie/popular?api_key=$this->api_key";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        return view('movie.index', compact('responseBody'));
    }

    public function search(Request $request){
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $client = new Client();
                $url = "$this->base_url/search/movie?api_key=$this->api_key&query=$query";

                $response = $client->request('GET', $url, [
                    'verify'  => false,
                ]);

                $data = json_decode($response->getBody());
                return $data;
            }
        }
    }
}
