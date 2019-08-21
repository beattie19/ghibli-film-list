<?php

namespace App\Services\GhibliApiService;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GhibliApi
{
    private $client;

    /**
     * GhibliApi constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getFilms(): array
    {
        $response = $this->client->request('GET', 'https://ghibliapi.herokuapp.com/films');
        return $response->toArray();
    }
}