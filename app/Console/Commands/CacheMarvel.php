<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class CacheMarvel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marvel:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves data from Marvel API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getFromMarvelToCache('comics');
        $this->getFromMarvelToCache('characters');
    }

    private function getFromMarvelToCache($endpoint)
    {

        if (Cache::has('$endpoint')) {
            $this->info("Forgetting the old cache value");
            Cache::forget('$endpoint');
        }

        $ts   = time();
        $hash = md5($ts . env('PRIVATE_KEY') . env('PUBLIC_KEY'));

        $client = new Client([
            'base_uri' => env('BASE_URL'),
            'query' => [
                    'apikey' => env('PUBLIC_KEY'),
                    'ts' => $ts,
                    'hash' => $hash
            ]
        ]);


        $firstQuery = $client->getConfig('query');
        $firstQuery['limit'] = 1;
        $response = $client->get(env('BASE_URL') . $endpoint, ['query' => $firstQuery]);
        $response = json_decode($response->getBody(), true);
        $totalCount = $response['data']['total'];

        $resultsPerPage = 100;
        $pageCount = 16;
        $minutesToCache = 10080; //set cache time to 7 days || 1 day = 1440 minutes.

        $data = [];
        $this->info("Obtaining $endpoint from Marvel server!");
        $this->info('Page count: ' . $pageCount);
        $this->info('Url: ' . env('BASE_URL') . $endpoint );
        $bar = $this->output->createProgressBar($pageCount);

        for($x = 0; $x <= $pageCount; $x++){

            $query = $client->getConfig('query');
            $query['limit'] = $resultsPerPage;
            $query['offset'] = $resultsPerPage * $x;

            $response = $client->get(env('BASE_URL') . $endpoint, ['query' => $query]);
            $response = json_decode($response->getBody(), true);
            $currentData = $response['data']['results'];

            $data = array_merge($data, $currentData );

            $bar->advance();
        }
        Cache::put($endpoint, $currentData, $minutesToCache);
    }
}
