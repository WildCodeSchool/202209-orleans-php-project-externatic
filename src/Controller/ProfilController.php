<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProfilController extends AbstractController
{
    #[IsGranted("ROLE_RECRUITER")]
    #[Route('/profil/{id}', name: 'app_profil_candidate')]
    public function showProfil(Candidate $candidate): Response
    {
        return $this->render('profil/show.html.twig', [
            'candidate' => $candidate
        ]);
    }
}
