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

    private function getPeopleJson($data) { 
        return json_encode($res);
    }

    private function getPeopleHTML($data) {
        $res = array();

        foreach($data as $d) {
            $char['character_name'] = $d['name'];
            $char['character_age'] = $d['age'];
            $char['film_title'] = $d['film']['title'];
            $char['film_release_date'] = $d['film']['release_date'];
            $char['film_score'] = $d['film']['score'];
            array_push($res, $char);
        }      
        
        return json_encode($res);
    }

    public function getPeople(Request $request, $fmt) {
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

        if($fmt == "json") {
            return json_encode($res);
        } else if($fmt == 'html') {
            return view('dataTable', ['data' => $res]);
        }

        return "Incorrect format, try one of these json, csv, html";
    }
}
