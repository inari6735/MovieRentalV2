<?php

namespace App\Controller;

use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    #[Route('/collection', name: 'app_collection')]
    public function index(
        CollectionRepository $collectionRepository
    ): Response
    {
        $userId = $this->getUser()->getId();
        $movies = $collectionRepository->getCollectionMoviesData($userId);
        $collectionMovies = $collectionRepository->findBy(['userId' => $userId]);

        return $this->render('collection/index.html.twig', [
            'movies' => $movies,
            'collectionMovies' => $collectionMovies
        ]);
    }
}
