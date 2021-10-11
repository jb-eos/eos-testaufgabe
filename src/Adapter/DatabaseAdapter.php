<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Data\User;
use App\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseAdapter implements AdapterInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getUser(int $id): ?User
    {
        $entityUser = $this->entityManager->getRepository(UserEntity::class)->find($id);
        if ($entityUser === null) {
            return null;
        }

        return $this->createUserFromEntity($entityUser);
    }

    public function getUsers(): array
    {
        $userEntities = $this->entityManager->getRepository(UserEntity::class)->findAll();

        $users = [];
        foreach ($userEntities as $userEntity) {
            $users[] = $this->createUserFromEntity($userEntity);
        }

        return $users;
    }

    public function addUser(User $user): void
    {
        $userEntity = $this->createEntityFromUser($user);
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
        $user->setId($userEntity->getId());
    }

    public function updateUser(User $user): void
    {
        /** @var UserEntity $userEntity */
        $userEntity = $this->entityManager->getRepository(UserEntity::class)->find($user->getId());
        $userEntity->setFirstName($user->getFirstName());
        $userEntity->setLastName($userEntity->getLastName());
        $this->entityManager->flush();
    }

    public function deleteUser(User $user): void
    {
        $userEntity = $this->entityManager->getRepository(UserEntity::class)->find($user->getId());
        $this->entityManager->remove($userEntity);
        $this->entityManager->flush();
    }

    private function createUserFromEntity(UserEntity $userEntity): User
    {
        $user = new User();
        $user->setId($userEntity->getId());
        $user->setFirstName($userEntity->getFirstName());
        $user->setLastName($userEntity->getLastName());

        return $user;
    }

    private function createEntityFromUser(User $user): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->setFirstName($user->getFirstName());
        $userEntity->setLastName($user->getLastName());

        return $userEntity;
    }
}
