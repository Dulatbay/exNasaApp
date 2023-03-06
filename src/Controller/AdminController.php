<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: 'manager/users-list', name: 'users-list')]
    public function adminpage(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findAll();
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('adminpage.html.twig', [
            'pagination' => $pagination,
            'canBan' => $this->isGranted('ROLE_MANAGER'),
            'canDelete' => $this->isGranted('ROLE_ADMIN'),
        ]);
    }

    #[Route(path: "manager/users/{id}/ban", name: "user_ban")]
    public function banUser(User $user): RedirectResponse
    {
        $user->setIsBanned(!$user->isIsBanned());
        $this->entityManager->flush();
        return $this->redirectToRoute('users-list');
    }

    #[Route(path: "admin/users/{id}/edit/", name: "user_edit", methods: ["PATCH"])]
    public function edit(Request $request, $id, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }

        $data = json_decode($request->getContent(), true);

        $password = $data['password'];

        $encodedPassword = $hasher->hashPassword($user, $password);
        $user->setPassword($encodedPassword);
        $this->entityManager->flush();
        return $this->json(['success' => true]);
    }

    #[Route(path: "admin/users/{id}/delete", name: "user_delete")]
    public function deleteUser($id): Response
    {
        $this->entityManager->remove($this->entityManager->getRepository(User::class)->find($id));
        $this->entityManager->flush();
        return $this->redirectToRoute('users-list');
    }
}