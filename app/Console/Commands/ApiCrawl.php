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
        echo 'CRAWLER STARTED!'.PHP_EOL;
        $client = new Client(['base_uri' => 'https://ghibliapi.herokuapp.com/']);
        $response = $client->request('GET', 'films');
        $data = json_decode($response->getBody()->getContents(), true);
        $count = 0;
        foreach($data as $film) {  
            echo 'LOADING: '.$count.' FROM '.count($data).PHP_EOL;         
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
                $charFilm = Film::where('title', '=', $film['title'])->first();                                                                  
                foreach($film['people'] as $charUrls) {                        
                    $c = new Client();
                    $r = $client->request('GET', $charUrls);
                    $d = json_decode($r->getBody()->getContents(), true);            
                    if($charUrls == 'https://ghibliapi.herokuapp.com/people/') {                                                                       
                        foreach($d as $charData) {   
                            $filmsParticipation = array();

                            foreach($charData['films'] as $fp) {
                                $ca = new Client();
                                $ra = $client->request('GET', $fp);
                                $da = json_decode($ra->getBody()->getContents(), true);
                                array_push($filmsParticipation, $da['title']);
                            }

                            foreach($filmsParticipation as $fp) {
                                if($fp == $film['title']) {
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
                    }
                    else {
                        $newChar = new Character;
                        $newChar->film_id = $charFilm->film_id;
                        $newChar->name = $d['name'];
                        $newChar->gender = $d['gender'];
                        $newChar->age = $d['age'];
                        $newChar->eye_color = $d['eye_color'];
                        $newChar->hair_color = $d['hair_color'];
                        $newChar->save();                          
                    }                        
                }                      
            }
            $count += 1;
        }
        echo 'CRAWLER FINISHED!'.PHP_EOL;
    }    
}