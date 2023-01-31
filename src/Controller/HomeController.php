<?php

namespace App\Controller;

use App\Form\SearchOfferType;
use App\Services\OfferToJson;
use App\Services\OfferFounder;
use App\Entity\SearchOfferModule;
use App\Services\Geolocalisation;
use App\Repository\SponsorRepository;
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
        OfferToJson $offerToJson,
        Geolocalisation $geolocalisation,
    ): Response {
        $sponsors = $sponsorRepository->findAll();
        $searchOfferModule = new SearchOfferModule();
        $form = $this->createForm(SearchOfferType::class, $searchOfferModule);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offers = $offerFounder->foundByLocation($searchOfferModule);
            $searchCoords = $geolocalisation->find($searchOfferModule->getLocation() ?? "");

            if ($this->getUser()) {
                $template = 'offer/showAll.html.twig';
            } else {
                $template = 'offer/index.html.twig';
            }

            return $this->renderForm($template, [
                'form' => $form,
                'offers' => $offers,
                'jsonOffers' => $offerToJson->get($offers),
                'searchCoords' => json_encode($searchCoords),
            ]);
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'sponsors' => $sponsors,
        ]);
    }
}
