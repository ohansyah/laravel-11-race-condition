<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class DashboardController extends Controller
{
    public function index()
    {
        $this->sequential();
        $this->concurrent();
    }

    private function sequential()
    {
        $startTime = microtime(true);

        $weatherData = json_decode((new Client())->get('https://api.open-meteo.com/v1/forecast?latitude=-6.2088&longitude=106.8456&current_weather=true')->getBody()->getContents(), true);
        $quotesData = json_decode((new Client())->get('https://zenquotes.io/api/random')->getBody()->getContents(), true);
        $jokesData = json_decode((new Client())->get('https://official-joke-api.appspot.com/jokes/programming/random')->getBody()->getContents(), true);
        $foodData = json_decode((new Client())->get('https://www.themealdb.com/api/json/v1/1/random.php')->getBody()->getContents(), true);
        $chuckData = json_decode((new Client())->get('https://api.chucknorris.io/jokes/random')->getBody()->getContents(), true);
        $uselessData = json_decode((new Client())->get('https://uselessfacts.jsph.pl/api/v2/facts/random')->getBody()->getContents(), true);
        $techyData = (new Client())->get('https://techy-api.vercel.app/api/text')->getBody()->getContents();

        dump([
            'weather' => $weatherData,
            'quotes' => $quotesData,
            'jokes' => $jokesData,
            'food' => $foodData,
            'chuck' => $chuckData,
            'useless' => $uselessData,
            'techy' => $techyData,
            'sequential_execution_time' => microtime(true) - $startTime,
        ]);
    }

    private function concurrent()
    {
        $startTime = microtime(true);

        $client = new Client();
        $promises = [
            'weather' => $client->getAsync('https://api.open-meteo.com/v1/forecast?latitude=-6.2088&longitude=106.8456&current_weather=true'),
            'quotes' => $client->getAsync('https://zenquotes.io/api/random'),
            'jokes' => $client->getAsync('https://official-joke-api.appspot.com/jokes/programming/random'),
            'food' => $client->getAsync('https://www.themealdb.com/api/json/v1/1/random.php'),
            'chuck' => $client->getAsync('https://api.chucknorris.io/jokes/random'),
            'useless' => $client->getAsync('https://uselessfacts.jsph.pl/api/v2/facts/random'),
            'techy' => $client->getAsync('https://techy-api.vercel.app/api/text'),
        ];

        $responses = Promise\Utils::unwrap($promises);

        $weatherData = json_decode($responses['weather']->getBody()->getContents(), true);
        $quotesData = json_decode($responses['quotes']->getBody()->getContents(), true);
        $jokesData = json_decode($responses['jokes']->getBody()->getContents(), true);
        $foodData = json_decode($responses['food']->getBody()->getContents(), true);
        $chuckData = json_decode($responses['chuck']->getBody()->getContents(), true);
        $uselessData = json_decode($responses['useless']->getBody()->getContents(), true);
        $techyData = $responses['techy']->getBody()->getContents();

        dump([
            'weather' => $weatherData,
            'quotes' => $quotesData,
            'jokes' => $jokesData,
            'food' => $foodData,
            'chuck' => $chuckData,
            'useless' => $uselessData,
            'techy' => $techyData,
            'concurrent_execution_time' => microtime(true) - $startTime,
        ]);
    }
}
