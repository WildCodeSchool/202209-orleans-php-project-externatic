<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use App\Form\ApplicationResponseType;
use App\Form\RecruiterType;
use App\Repository\ApplicationRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruiterController extends AbstractController
{
    #[Route('/espace-recruteur/candidatures', name: 'app_recruiter_application')]
    public function showApplications(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('recruiter/applications.html.twig', [
            'offers' => $offers,
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
