<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Repository\CartRepository;
use App\Repository\CollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'payment' => 'app_make_payment',
            'movieId' => Null
        ]);
    }

    #[Route('/payment/make', name: 'app_make_payment')]
    public function makePayment(
        CartRepository $cartRepository,
        CollectionRepository $collectionRepository
    ): Response
    {
        $userId = $this->getUser()->getId();

        $cartMovies = $cartRepository->findBy(['userId' => $userId]);
        foreach($cartMovies as $cartMovie)
        {
            $collectionMovie = new Collection();
            $collectionMovie->setUserId($userId)
                ->setMovieId($cartMovie->getMovieId())
                ->setDateStart(new \DateTime())
                ->setDateEnd((new \DateTime())->modify('+30 days'));
            $this->entityManager->persist($collectionMovie);
            $this->entityManager->remove($cartMovie);
            $this->entityManager->flush();
        }


        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/make/{movieId}', name: 'app_make_one_payment')]
    public function makeOnePayment(
        int $movieId,
        CartRepository $cartRepository,
        CollectionRepository $collectionRepository
    ): Response
    {
        $userId = $this->getUser()->getId();

        $cartMovie = $cartRepository->findOneBy(['userId' => $userId, 'movieId' => $movieId]);
        $collectionExistingMovie = $collectionRepository->findOneBy(['userId' => $userId, 'movieId' => $movieId]);

        if($collectionExistingMovie) {
            return $this->redirectToRoute('app_get_movies');
        }

        if($cartMovie) {
            $this->entityManager->remove($cartMovie);
        }

        $collectionMovie = new Collection();
        $collectionMovie->setUserId($userId)
            ->setMovieId($movieId)
            ->setDateStart(new \DateTime())
            ->setDateEnd((new \DateTime())->modify('+30 days'));
        $this->entityManager->persist($collectionMovie);
        $this->entityManager->flush();

        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/make/one/{movieId}', name: 'app_one_payment')]
    public function onePayment(
        int $movieId
    ): Response
    {
        return $this->render('payment/index.html.twig', [
            'payment' => 'app_make_one_payment',
            'movieId' => $movieId
        ]);
    }
}
