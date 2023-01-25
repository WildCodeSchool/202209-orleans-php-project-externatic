<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use App\Repository\CandidateRepository;
use App\Repository\RecruiterRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminUserController extends AbstractController
{
    public const ROLES = [
        "ROLE_ADMIN" => "Administrateur",
        "ROLE_RECRUITER" => "Recruteur",
        "ROLE_CANDIDATE" => "Candidat",
        "ROLE_USER" => "Visiteur",
    ];

    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findBy([], ['lastname' => 'ASC',]),
        ]);
    }

    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository,
        RecruiterRepository $recruiterRepository,
        CandidateRepository $candidateRepository,
    ): Response {
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            $roles = $user->getRoles();
            if (in_array("ROLE_RECRUITER", $roles)) {
                if ($user->getRecruiter() === null) {
                    $recruiter = new Recruiter();
                    $recruiter->setUser($user);

                    $recruiterRepository->save($recruiter, true);
                    $this->addFlash("success", "Le rôle recruteur a bien été ajouté");
                }
            }

            if (in_array("ROLE_CANDIDATE", $roles)) {
                if ($user->getCandidate() === null) {
                    $candidate = new Candidate();
                    $candidate->setUser($user);

                    $candidateRepository->save($candidate, true);
                    $this->addFlash("success", "Le rôle candidat a bien été ajouté");
                }
            }

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);

            $this->addFlash("success", "Utilisateur supprimé avec succès.");
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
