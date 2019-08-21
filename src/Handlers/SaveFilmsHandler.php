<?php

namespace App\Handlers;

use App\Services\GhibliApiService\GhibliApi;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Film;

class SaveFilmsHandler {

    private $ghibliApiService;
    private $entityManager;

    public function __construct(GhibliApi $ghibliApiService, EntityManagerInterface $entityManager) {
        $this->ghibliApiService = $ghibliApiService;
        $this->entityManager = $entityManager;
    }

    public function getFilms() {

        $connection = $this->entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('film', true));

        $films = $this->ghibliApiService->getFilms();
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