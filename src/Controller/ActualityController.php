<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Form\ActualityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualityController extends AbstractController {

    /**
     * add a actuality
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/', name: 'actuality_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response {

        $actuality = new Actuality();
        $form = $this->createForm(ActualityType::class, $actuality);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actuality);
            $entityManager->flush();
            $this->addFlash("success", "L'actuality a été créé avec succès !");
        }

        return $this->render('actuality/add.html.twig', ['form' => $form->createView()] );
    }

}
