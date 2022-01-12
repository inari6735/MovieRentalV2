<?php

namespace App\Controller;

use App\Repository\CartRepository;
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
        return $this->render('payment/index.html.twig');
    }

    #[Route('/payment/make', name: 'app_make_payment')]
    public function makePayment(
        CartRepository $cartRepository
    ): Response
    {
        $userId = $this->getUser()->getId();

        $cartMovies = $cartRepository->findBy(['userId' => $userId]);
        foreach($cartMovies as $cartMovie)
        {
            $this->entityManager->remove($cartMovie);
            $this->entityManager->flush();
        }

        return $this->render('payment/success.html.twig');
    }
}
