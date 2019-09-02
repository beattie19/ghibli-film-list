<?php

namespace App\Services\ImdbImageService;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImdbImageApi
{
    private $client;

    /**
     * ImdbImageApi constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getImageForFilm(string $filmTitle): array
    {
        $filmTitle = strtolower($filmTitle);
        $filmTitle = str_replace(' ', '+', $filmTitle);

        $response = $this->client->request('GET', 'http://www.omdbapi.com/?t='. $filmTitle . '&apikey=27f8c9a4&cache=false');
        return $response->toArray();
    }
}