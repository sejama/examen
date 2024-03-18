<?php

namespace App\Controller;

use App\Entity\Provincia;
use App\Form\ProvinciaType;
use App\Repository\ProvinciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/provincia')]
class ProvinciaController extends AbstractController
{
    #[Route('/', name: 'app_provincia_index', methods: ['GET'])]
    public function index(ProvinciaRepository $provinciaRepository): Response
    {
        return $this->render('provincia/index.html.twig', [
            'provincias' => $provinciaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_provincia_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $provincia = new Provincia();
        $form = $this->createForm(ProvinciaType::class, $provincia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($provincia);
            $entityManager->flush();

            return $this->redirectToRoute('app_provincia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provincia/new.html.twig', [
            'provincia' => $provincia,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provincia_show', methods: ['GET'])]
    public function show(Provincia $provincia): Response
    {
        return $this->render('provincia/show.html.twig', [
            'provincia' => $provincia,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_provincia_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Provincia $provincia, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProvinciaType::class, $provincia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_provincia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provincia/edit.html.twig', [
            'provincia' => $provincia,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provincia_delete', methods: ['POST'])]
    public function delete(Request $request, Provincia $provincia, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$provincia->getId(), $request->request->get('_token'))) {
            $entityManager->remove($provincia);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_provincia_index', [], Response::HTTP_SEE_OTHER);
    }
}
