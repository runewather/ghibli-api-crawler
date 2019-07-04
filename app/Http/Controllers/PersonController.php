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

    private function getPeopleCSV($data) {
        $file = "data.csv";
        $csv = fopen($file, "w") or die("Unable to open file!");
        
        $tableHead = array('Name', 'Age', 'Film', 'Release Date', 'Film Score');
        fputcsv($csv, $tableHead);

        foreach($data as $row) {
            fputcsv($csv, $row);
        }

        fclose($csv);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        
        readfile($file);
    }

    public function filterData($data) {
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
    
    public function getPeopleJSON() {
        $data = $this->personRepository->getPeople(); 
        return json_encode($this->filterData($data));
    }

    public function getPeopleFormat(Request $request, $fmt) {
        $data = $this->personRepository->getPeople(); 

        $res = $this->filterData($data);          

        if($fmt == "json") {
            return json_encode($res);
        } else if($fmt == 'html') {
            return view('dataTable', ['data' => $res]);
        } else if($fmt == 'csv') {
            $this->getPeopleCSV($res);
        }

        return "Incorrect format, try one of these json, csv, html";
    }
}
