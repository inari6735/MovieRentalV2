<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class HomeController extends BaseController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->redirectToRoute('app_get_movies');
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/admin/protected', name: 'app_admin_protected')]
    public function adminProtected(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PROTECTED_ADMIN');

        return new Response('Protected content');
    }
}
