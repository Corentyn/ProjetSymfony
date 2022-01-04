<?php

namespace App\Controller;

use App\Entity\VeilleInformatique;
use App\Form\VeilleInformatiqueType;
use App\Repository\VeilleInformatiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/veille/informatique')]
class VeilleInformatiqueController extends AbstractController
{
    #[Route('/', name: 'veille_informatique_index', methods: ['GET'])]
    public function index(VeilleInformatiqueRepository $veilleInformatiqueRepository): Response
    {
        return $this->render('veille_informatique/index.html.twig', [
            'veille_informatiques' => $veilleInformatiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'veille_informatique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veilleInformatique = new VeilleInformatique();
        $form = $this->createForm(VeilleInformatiqueType::class, $veilleInformatique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veilleInformatique);
            $entityManager->flush();

            return $this->redirectToRoute('veille_informatique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veille_informatique/new.html.twig', [
            'veille_informatique' => $veilleInformatique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'veille_informatique_show', methods: ['GET'])]
    public function show(VeilleInformatique $veilleInformatique): Response
    {
        return $this->render('veille_informatique/show.html.twig', [
            'veille_informatique' => $veilleInformatique,
        ]);
    }

    #[Route('/{id}/edit', name: 'veille_informatique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VeilleInformatique $veilleInformatique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeilleInformatiqueType::class, $veilleInformatique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('veille_informatique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veille_informatique/edit.html.twig', [
            'veille_informatique' => $veilleInformatique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'veille_informatique_delete', methods: ['POST'])]
    public function delete(Request $request, VeilleInformatique $veilleInformatique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veilleInformatique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($veilleInformatique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('veille_informatique_index', [], Response::HTTP_SEE_OTHER);
    }
}
