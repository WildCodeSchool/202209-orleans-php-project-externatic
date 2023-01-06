<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidate;
use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/experience')]
class ExperienceController extends AbstractController
{
    #[Route('/ajouter', name: 'app_experience_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExperienceRepository $experienceRepository,): Response
    {

        $experience = new Experience();
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        /** @var User */
        $user = $this->getUser();

        $candidate = $user->getCandidate();

        if ($form->isSubmitted() && $form->isValid()) {
            $experience->setCandidate($candidate);
            $experienceRepository->save($experience, true);

            $this->addFlash('success', 'Votre expérience a été ajoutée.');

            return $this->redirectToRoute('app_candidate_show', [
                'id' => $candidate->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experience/new.html.twig', [
            'experience' => $experience,
            'form' => $form,

        ]);
    }

    #[Route('/{id}/modifier', name: 'app_experience_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Experience $experience, ExperienceRepository $experienceRepository): Response
    {
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $experienceRepository->save($experience, true);

            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute('app_candidate_show', [
                'id' => $experience->getCandidate()->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experience/edit.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_experience_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Experience $experience,
        ExperienceRepository $experienceRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $experience->getId(), $request->request->get('_token'))) {
            $experienceRepository->remove($experience, true);
        }

        $this->addFlash('success', 'La suppression a été effectuée avec succès.');

        return $this->redirectToRoute('app_candidate_show', [
            'id' => $experience->getCandidate()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
