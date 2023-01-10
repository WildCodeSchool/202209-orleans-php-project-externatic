<?php

namespace App\Controller;

use DateTime;
use App\Entity\Offer;
use App\Form\OfferType;
use App\Form\SearchOfferType;
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/offer', name: 'app_offer_')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(SearchOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $keyWord = $form->getData()['search'];
            $keyWord = trim($keyWord);

            $keyWord ? $offers = $offerRepository->findByKeyWord($keyWord) : $offers = $offerRepository->findAll();
        } else {
            $offers = $offerRepository->findAll();
        }

        return $this->renderForm('offer/index.html.twig', [
            'offers' => $offers,
            'form' => $form,
        ]);
    }
    #[Route('/toutes-les-offres', name: 'showAll', methods: ['GET'])]
    public function showAll(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/showAll.html.twig', [
            'offers' => $offerRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, OfferRepository $offerRepository): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepository->save($offer, true);

            return $this->redirectToRoute('app_offer_index');
        }

        return $this->renderForm('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show_loggedin', methods: ['GET'])]
    public function isLogShow(Offer $offer): Response
    {
        return $this->render('offer/isLogShow.html.twig', [
            'offer' => $offer,
        ]);
    }
    #[Route('/loggedout/{id}', name: 'show_loggedout', methods: ['GET'])]
    public function isNotLogShow(Offer $offer): Response
    {
        return $this->render('offer/isNotLogShow.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepository->save($offer, true);

            return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $offerRepository->remove($offer, true);
        }

        return $this->redirectToRoute('app_offer_showAll', [], Response::HTTP_SEE_OTHER);
    }
}
