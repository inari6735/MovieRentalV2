<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cart/add/{movieId}', name: 'app_cart_add')]
    public function addMovie(
        int $movieId,
        CartRepository $cartRepository
    ): Response
    {
        $cartItem = new Cart();
        $user = $this->getUser();
        $userId = $user->getId();

        $existingItem = $cartRepository->findOneBy(['movieId' => $movieId, 'userId' => $userId]);
        if($existingItem)
        {
            return $this->redirectToRoute('app_get_movies');
        }

        $cartItem->setUserId($userId);
        $cartItem->setMovieId($movieId);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_get_movies');
    }

    #[Route('/cart', name: 'app_cart')]
    public function getCart(
        CartRepository $cartRepository
    ): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $priceSum = null;

        $movies = $cartRepository->findMoviesByUserId($userId);
        foreach($movies as $movie)
        {
            $priceSum += $movie->getPrice();
        }

        return $this->render('cart/index.html.twig', [
            'movies' => $movies,
            'priceSum' => $priceSum
        ]);
    }

    #[Route('/cart/delete/{movieId}', name: 'app_cart_delete')]
    public function deleteFromCart(
        int $movieId,
        CartRepository $cartRepository
    ): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $movie = $cartRepository->findOneBy(['userId' => $userId, 'movieId' => $movieId]);


        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_cart');
    }
}
