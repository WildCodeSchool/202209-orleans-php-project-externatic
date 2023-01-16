<?php

namespace App\Controller;

use App\Repository\OfferRepository;
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
        //dd($offer);
        return $this->render('recruiter/showApplications.html.twig', [
            'offer' => $offer,
        ]);
    }
}
