<?php

namespace App\Command;

use App\Repository\FilmRepository;
use App\Services\ImdbImageService\ImdbImageApi;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SaveImdbImageCommand extends Command
{
    protected static $defaultName = 'app:save-imdb-images';

    private $filmRepository;
    private $imdbImageApi;
    private $entityManager;
    /*
     * SaveImdbImageCommand constructor.
     * @param FilmRepository $filmRepository
     */
    public function __construct(FilmRepository $filmRepository, ImdbImageApi $imdbImageApi, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        
        $this->filmRepository = $filmRepository;
        $this->imdbImageApi = $imdbImageApi;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $films = $this->filmRepository->findAll();
        foreach($films as $film) {
            $filmPoster = $this->imdbImageApi->getImageForFilm($film->getTitle());

            $film->setPoster($filmPoster['Poster']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $this->entityManager->persist($film);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
        }
    }
}
