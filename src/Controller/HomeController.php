<?php

namespace App\Controller;

use App\Form\SearchOfferType;
use App\Repository\OfferRepository;
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
        OfferRepository $offerRepository,
        SponsorRepository $sponsorRepository,
    ): Response {
        $sponsors = $sponsorRepository->findAll();
        $form = $this->createForm(SearchOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $keyWord = $form->getData()['search'];
            $keyWord = trim($keyWord);

            $keyWord ? $offers = $offerRepository->findByKeyWord($keyWord) : $offers = $offerRepository->findAll();

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
