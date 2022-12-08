<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Repository\ChansonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chansons = $entityManager->getRepository(Chanson::class)->findAll();
        return $this->render('home/index.html.twig', [
                    'chansons' => $chansons
        ]);
    }
}
