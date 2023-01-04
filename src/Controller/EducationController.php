<?php

namespace App\Controller;

use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/education')]
class EducationController extends AbstractController
{
    #[Route('/new', name: 'app_education_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EducationRepository $educationRepository): Response
    {
        $education = new Education();
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $educationRepository->save($education, true);

            return $this->redirectToRoute('app_education_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('education/new.html.twig', [
            'education' => $education,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_education_show', methods: ['GET'])]
    public function show(Education $education): Response
    {
        return $this->render('education/show.html.twig', [
            'education' => $education,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_education_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Education $education, EducationRepository $educationRepository): Response
    {
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $educationRepository->save($education, true);

            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute('app_candidate_show', [
                'id' => $education->getCandidate()->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('education/edit.html.twig', [
            'education' => $education,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_education_delete', methods: ['POST'])]
    public function delete(Request $request, Education $education, EducationRepository $educationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $education->getId(), $request->request->get('_token'))) {
            $educationRepository->remove($education, true);
        }

        return $this->redirectToRoute('app_education_index', [], Response::HTTP_SEE_OTHER);
    }
}
