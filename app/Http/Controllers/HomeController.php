<?php

namespace App\Http\Controllers;

use App\Services\MarvelService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $api;

    public function __construct()
    {
        $this->api = new MarvelService();
    }

    public function comics(Request $request)
    {

        if ($request->has('query')){
            $term = $request->input('query');
            $data = $this->api->comics($term);
            debug($data);
        } else {
            $data = $this->api->comics();
        }

        return view('comics', ['comics' => $data['comics'], 'query' => $data['term']]);
    }

    public function comic()
    {

    }

    public function characters()
    {

    }

    public function creators()
    {

    }

    public function events()
    {

    }

    public function series()
    {

    }

    public function stories()
    {

    }

}
