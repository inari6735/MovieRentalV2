<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\AddMoviesFormType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    #[Route('/movies/add', name: 'app_add_movie')]
    public function addMovie(
        Request $request,
    ): Response
    {
        $movie = new Movies();

        $form = $this->createForm(AddMoviesFormType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('movies/index.html.twig', [
            'moviesForm' => $form->createView()
        ]);
    }

    #[Route('/movies', name: 'app_get_movies')]
    public function getMovies(
        MoviesRepository $moviesRepository
    ): Response
    {
        $movies = $moviesRepository->findAll();
        return $this->render('home/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies/update/{movieId}', name: 'app_update_movies')]
    public function updateMovies(
        int $movieId,
        MoviesRepository $moviesRepository,
        Request $request
    ): Response
    {
        $movie = $moviesRepository->findOneBy(['id' => $movieId]);

        $form = $this->createForm(AddMoviesFormType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_update_movies', ['movieId' => $movieId]);
        }

        return $this->render('movies/update.html.twig', [
            'moviesForm' => $form->createView(),
            'movie' => $movie
        ]);
    }
}
