<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    
    #[Route('/user', name: 'app_user')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a page without having ROLE_USER');
    
        return $this->render('user/index.html.twig', [
           
        ]);
    }
}
