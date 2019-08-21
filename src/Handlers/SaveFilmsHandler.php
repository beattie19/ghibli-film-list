<?php

namespace App\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Film;

class SaveFilmsHandler {

    private $client;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->client = HttpClient::create();
        $this->entityManager = $entityManager;
    }

    public function getFilms() {
        $response = $this->client->request('GET', 'https://ghibliapi.herokuapp.com/films');
        $films = $response->toArray();
        
        $this->saveFilmsToDatabase($films);
    }

    private function saveFilmsToDatabase(array $films) {
        foreach($films as $filmData) {

            $film = new Film();
            $film->setTitle($filmData['title']);
            $film->setDirector($filmData['director']);
            $film->setReleaseDate($filmData['release_date']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $this->entityManager->persist($film);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
        }
    }
}