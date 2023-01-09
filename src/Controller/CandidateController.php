<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidat')]
class CandidateController extends AbstractController
{
    #[Route('/{id}', name: 'app_candidate_show', methods: ['GET'])]
    public function show(Candidate $candidate): Response
    {
        return $this->render('candidate/show.html.twig', [
            'user' => $candidate->getUser(),
            'candidate' => $candidate,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute(
                'app_candidate_edit',
                ['id' => $candidate->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
            'user' => $candidate->getUser(),
        ]);
    }

    #[Route('/{candidate}/{offer}/candidater', name: 'app_candidate_applyToJob', methods: ['GET','POST'])]
    public function applyToJob(
        Request $request,
        Candidate $candidate,
        Offer $offer,
        CandidateRepository $candidateRepository
    ): Response {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('apply-offer', $submittedToken)) {
            $candidate->addOffer($offer);
            $candidateRepository->save($candidate, true);
        }

        return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
