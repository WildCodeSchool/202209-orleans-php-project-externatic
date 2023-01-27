<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use App\Form\ApplicationResponseType;
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
        $offers = $offerRepository->findBy([], ['createdAt' => 'DESC']);

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

    #[Route('/recruiter/applications/{id}', name: 'app_recruiter_applications_details')]
    public function applicationsDetails(int $id, OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        return $this->render('recruiter/showApplications.html.twig', [
            'offer' => $offer,
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
