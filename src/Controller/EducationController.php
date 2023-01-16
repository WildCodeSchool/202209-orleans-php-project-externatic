<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;
use App\Service\VerifyEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;

#[Route('/formation')]
class EducationController extends AbstractController
{
    #[Route('/ajouter', name: 'app_education_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EducationRepository $educationRepository): Response
    {
        $education = new Education();
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        /** @var User */
        $user = $this->getUser();

        $candidate = $user->getCandidate();

        if ($form->isSubmitted() && $form->isValid()) {
            $education->setCandidate($candidate);
            $educationRepository->save($education, true);

            $this->addFlash('success', 'Votre formation a été ajoutée.');


            return $this->redirectToRoute('app_candidate_show', [
                'id' => $candidate->getId(),
            ], Response::HTTP_SEE_OTHER);
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
    public function edit(
        Request $request,
        Education $education,
        EducationRepository $educationRepository,
        VerifyEntity $verifyEntity
    ): Response {
        /** @var User */
        $user = $this->getUser();
        $educations = $user->getCandidate()->getEducation();

        if (!$verifyEntity->IsInCollection($education, $educations)) {
            throw new Exception("Pas d'accès");
        };

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

        $this->addFlash('success', 'La suppression a été effectuée avec succès.');

        return $this->redirectToRoute('app_candidate_show', [
            'id' => $education->getCandidate()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
