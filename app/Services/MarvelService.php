<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


/**
 *  Class used to get all data from marvel's API
 */
class MarvelService
{

    private $client;

    public function __construct()
    {
        $ts = time();
        $hash = md5($ts . env('PRIVATE_KEY') . env('PUBLIC_KEY'));

        $this->client = new Client([
            'base_uri' => env('BASE_URL'),
            'query' => [
                'apikey' => env('PUBLIC_KEY'),
                'ts' => $ts,
                'hash' => $hash
            ]
        ]);
    }

    public function comics($term = null)
    {

        $data = null;
        if ($term !== null) {

            $query = $this->client->getConfig('query');
            $query['titleStartsWith'] = $term;

            $response = $this->client->get(env('BASE_URL') . 'comics', ['query' => $query]);
            $response = json_decode($response->getBody(), true);

            $data['comics'] =  $response['data']['results'];
            $data['term']   = $term;
        } else {

            if (!Cache::has('comics')) {
                $offset = random_int(0, 5000);
                $limit  = 20;
                $this->addToCache('comics', $offset, $limit);
            }

            $comics = Cache::get('comics');
            shuffle($comics);

            $data['comics'] =  array_slice($comics, 0,20);
            $data['term'] = $term;
        }

        return $data;
    }

    public function comic($id)
    {

        $page_data = [];
        $query = $this->client->getConfig('query');

        //get a specific comic
        $response = $this->client->get('comics/' . $id, ['query' => $query]);

        $response = json_decode($response->getBody(), true);

        $comic = $response['data']['results'][0];
        $page_data['comic'] = $comic;

        if(!empty($comic['series'])){
            //get series data
            $series_response = $this->client->get($comic['series']['resourceURI']);
            $series_response = json_decode($series_response->getBody(), true);

            $page_data['series'] = $series_response['data']['results'][0];
        }

        return view('comic', $page_data);
    }

    public function characters($term = null)
    {

        $data = [];

        if ($term) {
            $query = $this->client->getConfig('query');
            $query['nameStartsWith'] = $term;

            $response = $this->client->get(env('BASE_URL') .'characters', ['query' => $query]);
            $response = json_decode($response->getBody(), true);

            $data['characters'] = $response['data']['results'];
            $data['term'] = $term;

            return $data;
        }

        if (!Cache::has('characters')) {
            $offset = random_int(0,1490);
            $limit = 100;
            $this->addToCache('characters', $offset, $limit);
        }

        $characters = Cache::get('characters');
        shuffle($characters);
        $data['characters'] = $characters;
        $data['term'] = $term;

        return $data;
    }

    public function creators()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'creators', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    public function events()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'events', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    public function series()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'series', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    public function stories()
    {
        $query = $this->client->getConfig('query');
        $response = $this->client->get(env('BASE_URL') .'stories', ['query' => $query]);
        $response = json_decode($response->getBody(), true);

        return $response['data']['results'];
    }

    private function addToCache($endpoint, $offset, $limit)
    {
        $query = $this->client->getConfig('query');
        $query['limit']  = $limit;
        $query['offset'] = $offset;

        $response = $this->client->get(env('BASE_URL') . $endpoint, ['query' => $query]);
        $response = json_decode($response->getBody(), true);
        Cache::put($endpoint, $response['data']['results'], 10080);
    }


}
