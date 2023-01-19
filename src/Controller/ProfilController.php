<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil_candidate')]
    public function showProfil(Candidate $candidate): Response
    {
        return $this->render('profil/show.html.twig', [
            'candidate' => $candidate
        ]);
    }
}
