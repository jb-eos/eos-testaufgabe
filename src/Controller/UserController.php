<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\User;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private UserManager $userManager)
    {
    }

    #[Route('/users/{id<\d+>?0}', name: 'users_index', methods: ['GET'])]
    public function index(int $id): JsonResponse
    {
        if ($id === 0) {
            $users = $this->userManager->getUsers();
            return $this->json($users);
        }

        $user = $this->userManager->getUser($id);
        if ($user === null) {
            return $this->json([], 404);
        }

        return $this->json($user);
    }

    #[Route('/users', name: 'users_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        if (empty($content['firstName']) || empty($content['lastName'])) {
            return new JsonResponse([], 400);
        }

        $user = new User();
        $user->setFirstName($content['firstName']);
        $user->setLastName($content['lastName']);

        $this->userManager->addUser($user);

        return $this->json($user, 201);
    }

    #[Route('/users/{id<\d+>?0}', name: 'users_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $user = $this->userManager->getUser($id);
        if ($user === null) {
            return new JsonResponse([], 404);
        }

        $content = json_decode($request->getContent(), true);
        if (empty($content['firstName']) || empty($content['lastName'])) {
            return new JsonResponse([], 400);
        }

        $user->setFirstName($content['firstName']);
        $user->setLastName($content['lastName']);
        $this->userManager->updateUser($user);

        return $this->json($user);
    }

    #[Route('/users/{id<\d+>?0}', name: 'users_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->userManager->getUser($id);
        if ($user === null) {
            return new JsonResponse([], 404);
        }

        $this->userManager->deleteUser($user);

        return $this->json([], 204);
    }
}
