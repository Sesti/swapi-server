<?php 

require 'vendor/autoload.php';

define('API_URL', 'https://swapi.co/api/');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, origin");

Flight::route('/api/v1/people', function(){
    $request = json_decode(file_get_contents(API_URL . "people/"));
    
    $persons = array_map(function($people){

        $person = (object) [
            'name' => $people->name,
            'gender' => $people->gender,
            'homeworld' => $people->homeworld,
            'starships' => $people->starships,        
        ];
        return $person;

    }, $request->results);

    $response = (object) [
        'count' => $request->count,
        'next' => $request->next,
        'previous' => $request->previous,
        'persons' => $persons
    ];

    //echo $response;
    Flight::json($response);
});

Flight::route('/api/v1/search', function(){
    $query = $_GET['s'];
    
    if(!isset($query) || empty($query)){
        Flight::json((object) ['count' => 0]);
        return;
    }

    $request = json_decode(file_get_contents(API_URL . "people/?search=" . $query));

    if(!$request->count){
        Flight::json((object) ['count' => 0]);
        return;
    }

    $persons = array_map(function($people){

        $person = (object) [
            'name' => $people->name,
            'gender' => $people->gender,
            'homeworld' => $people->homeworld,
            'starships' => $people->starships,        
        ];
        return $person;

    }, $request->results);

    $response = (object) [
        'count' => $request->count,
        'next' => $request->next,
        'previous' => $request->previous,
        'persons' => $persons
    ];

    //echo $response;
    Flight::json($response); 
    
});

Flight::route('/api/v1/planets', function(){
    $request = json_decode(file_get_contents(API_URL . "planets/"));
    
    $planets = array_map(function($planet){

        $planet = (object) [
            'name' => $planet->name,
            'diameter' => $planet->diameter,
            'gravity' => $planet->gravity,       
        ];
        return $planet;

    }, $request->results);

    $response = (object) [
        'count' => $request->count,
        'next' => $request->next,
        'previous' => $request->previous,
        'planets' => $planets
    ];

    //echo $response;
    Flight::json($response);
});

Flight::route('/api/v1/starships', function(){
    $request = json_decode(file_get_contents(API_URL . "starships/"));
    
    $starships = array_map(function($starship){

        $starship = (object) [
            'name' => $starship->name,
            'model' => $starship->model,
            'starship_class' => $starship->starship_class,       
        ];
        return $starship;

    }, $request->results);

    $response = (object) [
        'count' => $request->count,
        'next' => $request->next,
        'previous' => $request->previous,
        'starships' => $starships
    ];

    //echo $response;
    Flight::json($response);
});

Flight::start();