<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Form\ChansonType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChansonController extends AbstractController
{


    /**
     * @Route("/chanson/new", name="app_chanson_new")
     */
    public function ajoutChanson( Request $request , EntityManagerInterface $entityManager): Response
    {
        $chanson = new Chanson();
        $chanson->setDateAjout(new \DateTime());

        $form = $this->createForm(ChansonType::class, $chanson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $chanson = $form->getData();
            $entityManager->persist($chanson);
            $entityManager->flush();


            return $this->redirectToRoute('app_home');
        }

        return $this->render('chanson/index.html.twig', [
                'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/chanson/{id}", name="app_chanson")
     */
    public function detailChanson($id , EntityManagerInterface $entityManager): Response
    {
        $chanson = $entityManager->getRepository(Chanson::class)->find($id);
        return $this->render('chanson/detailChanson.html.twig', [
            'chanson' => $chanson
        ]);
    }
}
