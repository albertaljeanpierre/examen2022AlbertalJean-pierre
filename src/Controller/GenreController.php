<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="app_genre")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $genres = $entityManager->getRepository(Genre::class)->findAll();
        return $this->render('genre/index.html.twig', [
             'genres' => $genres
        ]);
    }

    /**
     * @Route("/genre/new", name="app_genre_new")
     */
    public function ajoutGenre(EntityManagerInterface $entityManager , Request $request) : Response
    {

        $genre = new Genre();


        $form = $this->createForm(GenreType::class, $genre );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $genre = $form->getData();
            $entityManager->persist($genre);
            $entityManager->flush();


            return $this->redirectToRoute('app_genre');
        }

        return $this->render('genre/genreListe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
