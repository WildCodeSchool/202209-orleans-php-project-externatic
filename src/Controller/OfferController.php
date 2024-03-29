<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Offer;
use App\Form\OfferType;
use App\Form\SearchOfferType;
use App\Services\OfferFounder;
use App\Entity\SearchOfferModule;
use App\Services\Geolocalisation;
use App\Repository\OfferRepository;
use App\Services\OfferToJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/offer', name: 'app_offer_')]
class OfferController extends AbstractController
{
    public const MAX_OFFER = 100;

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        OfferRepository $offerRepository,
        OfferFounder $offerFounder,
        OfferToJson $offerToJson,
        Geolocalisation $geolocalisation
    ): Response {
        $offers = $offerRepository->findBy([], ["createdAt" => "DESC"], self::MAX_OFFER);
        $searchOfferModule = new SearchOfferModule();
        $form = $this->createForm(SearchOfferType::class, $searchOfferModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offers = $offerFounder->foundByLocation($searchOfferModule);
            $searchCoords = $geolocalisation->find($searchOfferModule->getLocation() ?? "");
        }

        return $this->renderForm('offer/index.html.twig', [
            'form' => $form,
            'offers' => $offers,
            'jsonOffers' => $offerToJson->get($offers),
            'searchCoords' => json_encode($searchCoords ?? ""),
        ]);
    }
    #[Route('/toutes-les-offres', name: 'showAll', methods: ['GET', 'POST'])]
    public function showAll(
        Request $request,
        OfferRepository $offerRepository,
        OfferFounder $offerFounder,
        OfferToJson $offerToJson,
        Geolocalisation $geolocalisation
    ): Response {
        $offers = $offerRepository->findBy([], ["createdAt" => "DESC"], self::MAX_OFFER);
        $searchOfferModule = new SearchOfferModule();
        $form = $this->createForm(SearchOfferType::class, $searchOfferModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offers = $offerFounder->foundByLocation($searchOfferModule);
            $searchCoords = $geolocalisation->find($searchOfferModule->getLocation() ?? "");
        }

        return $this->renderForm('offer/showAll.html.twig', [
            'form' => $form,
            'offers' => $offers,
            'jsonOffers' => $offerToJson->get($offers),
            'searchCoords' => json_encode($searchCoords ?? ""),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, OfferRepository $offerRepository, Geolocalisation $geolocalisation): Response
    {
        $offer = new Offer();
        /** @var User */
        $user = $this->getUser();
        $offer->setRecruiter($user->getRecruiter());
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $offer->getCity();
            $postalCode = $offer->getPostalCode();
            $position = $geolocalisation->find($city, $postalCode);

            if (empty($position)) {
                $this->addFlash('danger', "Erreur, la ville ou le code postal saisi n'est pas valide");
            } else {
                $offer->setLongitude($position["lng"]);
                $offer->setLatitude($position["lat"]);

                $offerRepository->save($offer, true);

                return $this->redirectToRoute('app_offer_showAll');
            }
        }

        return $this->renderForm('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_RECRUITER') or is_granted('ROLE_CANDIDATE') or is_granted('ROLE_ADMIN')")]
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
    public function edit(
        Request $request,
        Offer $offer,
        OfferRepository $offerRepository,
        Geolocalisation $geolocalisation
    ): Response {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $offer->getCity();
            $postalCode = $offer->getPostalCode();
            $position = $geolocalisation->find($city, $postalCode);

            if (empty($position)) {
                $this->addFlash('danger', "Erreur, la ville ou le code postal saisi n'est pas valide");
                return $this->redirectToRoute('app_offer_edit', ["id" => $offer->getId()]);
            } else {
                $offer->setLongitude($position["lng"]);
                $offer->setLatitude($position["lat"]);

                $offerRepository->save($offer, true);
                return $this->redirectToRoute('app_offer_showAll', [], Response::HTTP_SEE_OTHER);
            }
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
