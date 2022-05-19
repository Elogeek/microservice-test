<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Form\ActualityType;
use App\Repository\ActualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualityController extends AbstractController {
    #[Route('/actuality', name: 'app_actuality')]
    public function index(): Response {
        return $this->render('actuality/index.html.twig');
    }

    /**
     * add a actuality
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/actuality/add', name: 'actuality_add')]
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

    /**
     * update a actuality
     * @param Actuality $actuality
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/actuality/update/{id}', name: 'actuality_update')]
    public function update(Actuality $actuality, Request $request, EntityManagerInterface $entityManager): Response {

        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "L'article a été modifié avec succès ! !");
            $actuId = $actuality->getId();
        }

        return $this->render('actuality/update.html.twig', ['form' => $form->createView(),'id' => $actuId] );
    }

    /**
     * delete a actuality and  redirect to homePage
     * @param Actuality $actuality
     * @param EntityManagerInterface $entityManager
     * @param ActualityRepository $repository
     * @return Response
     */
    #[Route('/actuality/delete/{id}', name: 'actuality_delete')]
    public function delete(Actuality $actuality, EntityManagerInterface $entityManager, ActualityRepository $repository): Response {
        $repository->delete($actuality->getId());
        $actuId = $actuality->getId();
        return $this->redirect("/", (int)['id' => $actuId]);
    }
}
