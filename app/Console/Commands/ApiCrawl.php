<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ApiCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database using the ghibli studio films';

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
        $client = new Client(['base_uri' => 'https://ghibliapi.herokuapp.com/']);
        $response = $client->request('GET', 'films');
        $data = json_decode($response->getBody()->getContents(), true);
        
        foreach($data as $film) {
            echo $film['title'].PHP_EOL;
            foreach($film['people'] as $p) {                
                echo nl2br($p.PHP_EOL);
            }
        }
        
    }
}
