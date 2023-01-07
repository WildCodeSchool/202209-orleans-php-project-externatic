<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('recruiter/index.html.twig', [
            'offers' => $offers,
        ]);
    }
}
