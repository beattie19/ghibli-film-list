<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Handlers\SaveFilmsHandler;

class SaveFilms extends Command {

    protected static $defaultName = 'app:save-films';

    private $handler;

    protected function configure()
    {
        $this
        ->setDescription('Saves film list to database.')
        ->setHelp('This command will request the list of Studio Ghibli films and store then in the database');
    }

    public function __construct(SaveFilmsHandler $handler) {
        $this->handler = $handler;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->handler->getFilms();
    }
}