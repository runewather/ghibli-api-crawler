<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Character;
use App\Models\Film;
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
        echo nl2br('CRAWLER STARTED!'.PHP_EOL);
        $client = new Client(['base_uri' => 'https://ghibliapi.herokuapp.com/']);
        $response = $client->request('GET', 'films');
        $data = json_decode($response->getBody()->getContents(), true);
        
        foreach($data as $film) {           
            $row = Film::where('title', '=', $film['title'])->first();
            if($row == null) {              
                $newFilm = new Film;
                $newFilm->title = $film['title'];
                $newFilm->description = $film['description'];
                $newFilm->director = $film['director'];
                $newFilm->producer = $film['producer'];
                $newFilm->release_date = $film['release_date'];
                $newFilm->score = $film['rt_score'];
                $newFilm->save();                

                foreach($film['people'] as $char) {  
                    $client = new Client();
                    $res = $client->request('GET', $char);
                    $data = json_decode($res->getBody()->getContents(), true);       
                    foreach($data as $charData) {
                        if(isset($charData['name'])) {
                            $charFilm = Film::where('title', '=', $film['title'])->first();
                            $newChar = new Character;
                            $newChar->film_id = $charFilm->film_id;
                            $newChar->name = $charData['name'];
                            $newChar->gender = $charData['gender'];
                            $newChar->age = $charData['age'];
                            $newChar->eye_color = $charData['eye_color'];
                            $newChar->hair_color = $charData['hair_color'];
                            $newChar->save();
                        }                        
                    }                       
                }
                echo nl2br($film['title'].' ADD!'.PHP_EOL);
            }
        }
        
    }
}
