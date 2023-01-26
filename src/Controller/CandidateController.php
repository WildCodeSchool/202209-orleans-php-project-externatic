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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
    public function showAll(CandidateRepository $candidateRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        $candidate = $user->getCandidate();

        $applications = $candidate->getApplications();

        if (count($applications) > 0) {
            foreach ($applications as $application) {
                if ($application->isNotification()) {
                    $application->setNotification(false);
                }
            }
            $candidateRepository->save($candidate, true);
        }

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

            $this->addFlash("success", "Votre candidature a bien été enregistrée.");
        }

        return $this->redirectToRoute('app_candidate_show_offers_applied', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/ajouter-aux-favoris', methods: ['GET', 'POST'], name: 'add_favorite')]
    public function addToFavorite(Offer $offer, CandidateRepository $candidateRepository): JsonResponse
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        $candidate = $user->getCandidate();

        if ($candidate->getFavorite()->contains($offer)) {
            $candidate->removeFavorite($offer);
        } else {
            $candidate->addFavorite($offer);
        }

        $candidateRepository->save($candidate, true);

        return $this->json(['isInFavorite' => $candidate->getFavorite()->contains($offer)]);
    }

    #[Route('/voir-mes-favoris', name: 'show_favories')]
    public function showMyFavorite(): Response
    {
        return $this->render('candidate/showFavorite.html.twig', []);
    }

    public function sidebarCandidate(): Response
    {
        /** @var User */
        $user = $this->getUser();
        $applications = $user->getCandidate()->getApplications();

        $numberOfResponses = 0;

        foreach ($applications as $application) {
            if ($application->isNotification()) {
                $numberOfResponses++;
            }
        }

        return $this->render('component/_sidenav_dashboard_candidate.html.twig', [

            'numberOfResponses' => $numberOfResponses,

        ]);
    }
}
