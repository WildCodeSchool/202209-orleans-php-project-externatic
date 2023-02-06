<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RecruiterType;
use App\Repository\UserRepository;
use App\Entity\Application;
use App\Services\ApplyStatus;
use App\Repository\OfferRepository;
use App\Form\ApplicationResponseType;
use App\Repository\SponsorRepository;
use App\Repository\ApplicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruiterController extends AbstractController
{
    #[Route('/espace-recruteur/candidatures', name: 'app_recruiter_application')]
    public function showApplications(OfferRepository $offerRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        $recruiterId = $user->getRecruiter()->getId();
        $offers = $offerRepository->findAllInProgress($recruiterId);

        return $this->render('recruiter/applications.html.twig', [
            'offers' => $offers,
        ]);
    }
    #[Route('/espace-recruteur/mes-offres', name: 'app_recruiter_myOffer')]
    public function showRecruiterOffer(OfferRepository $offerRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        $recruiterId = $user->getRecruiter()->getId();
        $offers = $offerRepository->findBy(["recruiter" => $recruiterId]);

        return $this->render('recruiter/showMyOffer.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/recruteur/mon-tableau-de-bord', methods: ['GET'], name: 'app_recruiter_dashboard')]
    public function showDashboard(ApplyStatus $applyStatus, SponsorRepository $sponsorRepository): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        $recruiter = $user->getRecruiter();

        return $this->render('recruiter/showDashboard.html.twig', [
            'sumApplicationInProgress' => $applyStatus->sumApplicationStatus(
                $recruiter,
                Application::APPLICATION_STATUS['IN_PROGRESS']
            ),
            'numberOfSponsor' => count($sponsorRepository->findAll()),
            'sumNoApplication' => $applyStatus->sumApplicationNoStatus($recruiter),

        ]);
    }

    #[Route('/recruiter/applications/{id}', name: 'app_recruiter_applications_details')]
    public function applicationsDetails(int $id, OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        return $this->render('recruiter/showApplications.html.twig', [
            'offer' => $offer,
        ]);
    }
    #[Route('/recruiter/modifier-mon-profil', name: 'app_recruiter_edit_profil')]
    public function editProfil(UserRepository $userRepository, Request $request): Response
    {
        /** @var User */
        $user = $this->getUser();
        $form = $this->createForm(RecruiterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash('success', 'Votre mise à jour a été prise en compte.');

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("recruiter/profilEdit.html.twig", [
            'form' => $form,
        ]);
    }

    #[Route('/recruiter/applicationDecision/{id}', name: 'app_recruiter_application_decision')]
    public function applicationDecision(
        int $id,
        Request $request,
        ApplicationRepository $applicationRepo
    ): Response {

        $application = $applicationRepo->find($id);
        $form = $this->createForm(ApplicationResponseType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setNotification(true);
            $applicationRepo->save($application, true);

            $this->addFlash('success', 'Votre décision est prise en compte');

            return $this->redirectToRoute(
                'app_recruiter_applications_details',
                ['id' => $application->getOffer()->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('recruiter/applicationDecision.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }
}
