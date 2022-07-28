<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomController extends AbstractController
{
    #[Route('/', name: 'app_welcom')]
    public function index(ManagerRegistry $manager): Response
    {
        $category=$manager->getRepository(Category::class)->findAll();
        return $this->render('welcom/index.html.twig', [
            'categories' => $category,
        ]);
    }
}
