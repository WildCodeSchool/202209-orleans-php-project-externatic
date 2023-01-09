<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\OfferRepository;
use App\Repository\CandidateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidat', name: 'app_candidate_')]
class CandidateController extends AbstractController
{
    #[Route('/{id}/mes-candidatures', name: 'show_offers_applied', methods: ['GET'])]
    public function showAll(Candidate $candidate): Response
    {
        return $this->render('candidate/showMyApplications.html.twig', [
            'candidate' => $candidate
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Candidate $candidate): Response
    {
        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
            'user' => $candidate->getUser(),
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute(
                'app_candidate_show',
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

    #[Route('/{candidate}/{offer}/candidater', name: 'apply_to_job', methods: ['GET', 'POST'])]
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
