<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 *  Class used to get all data from marvel's API
 */
class MarvelController extends Controller
{
    /**
     *  @var $client
     */
    private $client;

    public function __construct()
    {
        $ts = time();
        $hash = md5($ts . config('marvel.private_key') . config('marvel.public_key'));

        $this->client = new Client([
            'base_uri' => env('base_uri'),
            'query' => [
                'apikey' => env('PUBLIC_KEY'),
                'ts' => $ts,
                'hash' => $hash
            ]
        ]);
    }

/**
 * comics Method return a collection of all marvel's comics
 * @param   int $page param to show the chosen page
 * @return string with all marvel's comic in json format
 */
    public function comics(Request $request)
    {
        $query = $this->client->getConfig('query');

        if (Cache::has('comics')) {
            return Cache::get('comics');
        }

        if ($request->has('name')){
            $query['name'] = $request->input('name');
        }

        if ($request->has('nameStartsWith')){
            $query['nameStartsWith'] = $request->input('nameStartsWith');
        }

        if ($request->has('modifiedSince')){
            $query['modifiedSince'] = $request->input('modifiedSince');
        }

        if ($request->has('comics')){
            $query['comics'] = $request->input('comics');
        }

        if ($request->has('series')){
            $query['series'] = $request->input('series');
        }

        if ($request->has('events')){
            $query['events'] = $request->input('events');
        }

        if ($request->has('stories')){
            $query['stories'] = $request->input('stories');
        }

        // if (count($query) >= 4) {
            $response = $this->client->get(env('BASE_URL') . 'comics', ['query' => $query]);
            $response = json_decode($response->getBody(), true);
            return $response['data']['results'];

        // }
    }

    /**
     * [comic description]
     * @param  [type] $page [description]
     * @return [type]       [description]
     */
    public function characters()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'characters', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    /**
     * [creators description]
     * @return [type] [description]
     */
    public function creators()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'creators', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    /**
     * [events description]
     * @return [type] [description]
     */
    public function events()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'events', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    /**
     * d
     * @return [type] [description]
     */
    public function series()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'series', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    /**
     * [stories description]
     * @return [type] [description]
     */
    public function stories()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'stories', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

}
