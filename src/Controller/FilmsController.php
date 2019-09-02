<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{
    private $filmRepository;
    /**
     * FilmsController constructor.
     */
    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * @Route("/films", name="films")
     */
    public function index()
    {
        $films = $this->filmRepository->findAll();

        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films' => $films
        ]);
    }
}
