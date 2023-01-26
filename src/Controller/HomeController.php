<?php

namespace App\Controller;

use App\Entity\SearchOfferModule;
use App\Form\SearchOfferType;
use App\Repository\OfferRepository;
use App\Repository\SponsorRepository;
use App\Services\DistanceCalculator;
use App\Services\Geolocalisation;
use App\Services\OfferFounder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        SponsorRepository $sponsorRepository,
        OfferFounder $offerFounder,
    ): Response {
        $sponsors = $sponsorRepository->findAll();
        $searchOfferModule = new SearchOfferModule();
        $form = $this->createForm(SearchOfferType::class, $searchOfferModule);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offers = $offerFounder->foundByLocation($searchOfferModule);

            return $this->renderForm('offer/index.html.twig', [
                'form' => $form,
                'offers' => $offers,
            ]);
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'sponsors' => $sponsors,
        ]);
    }
}
