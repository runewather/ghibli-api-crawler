<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PersonRepository;

class PersonController extends Controller
{
    protected $personRepository;

    public function __construct(PersonRepository $personRepository){
        $this->personRepository = $personRepository;
    }

    public function getPeople(Request $request) {
        $data = $this->personRepository->getPeople(); 

        $res = array();

        foreach($data as $d) {
            $char['character_name'] = $d['name'];
            $char['character_age'] = $d['age'];
            $char['film_title'] = $d['film']['title'];
            $char['film_release_date'] = $d['film']['release_date'];
            $char['film_score'] = $d['film']['score'];
            array_push($res, $char);
        }      
        
        return $res;
    }
}
