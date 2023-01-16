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
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('recruiter/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/recruiter/applications/{id}', name: 'app_recruiter_applications_details')]
    public function applicationsDetails(int $id, OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);
        //dd($offer);
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
            $applicationRepo->save($application, true);

            $this->addFlash('success', 'Votre decision est prise en compte');

            return $this->redirectToRoute(
                'app_recruiter_application_decision',
                ['id' => $application->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('recruiter/applicationDecision.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }
}
