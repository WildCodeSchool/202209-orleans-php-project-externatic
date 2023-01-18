<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Candidate;
use App\Entity\Application;
use App\Form\CandidateType;
use App\Repository\OfferRepository;
use App\Repository\CandidateRepository;
use App\Repository\ApplicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidat', name: 'app_candidate_')]
class CandidateController extends AbstractController
{
    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(): Response
    {
        /** @var User */
        $user = $this->getUser();
        $candidate = $user->getCandidate();

        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/modifier', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CandidateRepository $candidateRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        $candidate = $user->getCandidate();


        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute(
                'app_candidate_show',
                ['id' => $user->getCandidate()->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/mes-candidatures', name: 'show_offers_applied', methods: ['GET'])]
    public function showAll(): Response
    {
        /** @var User */
        $user = $this->getUser();
        $candidate = $user->getCandidate();

        return $this->render('candidate/showMyApplications.html.twig', [
            'candidate' => $candidate
        ]);
    }


    #[Route('/{offer}/candidater', name: 'apply_to_job', methods: ['GET', 'POST'])]
    public function applyToJob(
        Request $request,
        Offer $offer,
        CandidateRepository $candidateRepository,
        ApplicationRepository $applicationRepo
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $candidate = $user->getCandidate();
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('apply-offer', $submittedToken)) {
            $application = new Application();
            $application->setApplicationStatus(Application::APPLICATION_STATUS['IN_PROGRESS']);
            $application->setOffer($offer);
            $candidate->addApplication($application);
            $applicationRepo->save($application, true);
            $candidateRepository->save($candidate, true);
        }

        return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
