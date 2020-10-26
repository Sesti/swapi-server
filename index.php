<?php

require 'vendor/autoload.php';

define('API_URL', 'https://swapi.dev/api/');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, origin");

Flight::route('/api/v1/people(/@page)', function ($page = 1) {
    $request = @json_decode(file_get_contents(API_URL . "people/?page=$page"));

    if ($request == null) {
        $response = (object) [
            'status' => 'none'
        ];
    } else {

        $persons = array_map(function ($people) {

            $person = (object) [
                'name' => $people->name,
                'gender' => $people->gender,
                'homeworld' => $people->homeworld,
                'starships' => $people->starships,
                'hairColor' => $people->hair_color,
                'skinColor' => $people->skin_color,
                'eyeColor' => $people->eye_color,
            ];
            return $person;
        }, $request->results);

        $response = (object) [
            'count' => $request->count,
            'next' => $request->next,
            'previous' => $request->previous,
            'persons' => $persons
        ];
    }

    Flight::json($response);
});

Flight::route('/api/v1/search(/@name)', function ($name) {

    if (empty($name)) {
        $response = (object) [
            'status' => 'none'
        ];
    } else {

        $request = @json_decode(file_get_contents(API_URL . "people/?search=$name"));

        if (isset($request->count) && $request->count === 0) {
            $response = (object) [
                'status' => 'none'
            ];
        } else {

            $persons = array_map(function ($people) {

                $person = (object) [
                    'name' => $people->name,
                    'gender' => $people->gender,
                    'homeworld' => $people->homeworld,
                    'starships' => $people->starships,
                    'hairColor' => $people->hair_color,
                    'skinColor' => $people->skin_color,
                    'eyeColor' => $people->eye_color,
                ];
                return $person;
            }, $request->results);

            $response = (object) [
                'count' => $request->count,
                'next' => $request->next,
                'previous' => $request->previous,
                'persons' => $persons
            ];
        }
    }

    Flight::json($response);
});

Flight::route('/api/v1/planets(/@page)', function ($page = 1) {
    $request = @json_decode(file_get_contents(API_URL . "planets/?page=$page"));

    if ($request == null) {
        $response = (object) [
            'status' => 'none'
        ];
    } else {
        $planets = array_map(function ($planet) {

            $planet = (object) [
                'name' => $planet->name,
                'diameter' => $planet->diameter,
                'gravity' => $planet->gravity,
                'climate' => $planet->climate,
                'population' => $planet->population
            ];
            return $planet;
        }, $request->results);

        $response = (object) [
            'count' => $request->count,
            'next' => $request->next,
            'previous' => $request->previous,
            'planets' => $planets
        ];
    }

    Flight::json($response);
});

Flight::route('/api/v1/starships(/@page)', function ($page = 1) {
    $request = @json_decode(file_get_contents(API_URL . "starships/?page=$page"));

    if ($request == null) {
        $response = (object) [
            'status' => 'none'
        ];
    } else {
        $starships = array_map(function ($starship) {

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
    }

    Flight::json($response);
});

Flight::route('/api/v1/starship/@id', function ($id) {
    $request = @json_decode(file_get_contents(API_URL . "starships/$id"));

    $starship = (object) [
        'name' => $request->name,
        'model' => $request->model,
        'starship_class' => $request->starship_class,
    ];

    Flight::json($starship);
});

Flight::start();
