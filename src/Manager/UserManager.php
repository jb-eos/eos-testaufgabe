<?php

declare(strict_types=1);

namespace App\Manager;

use App\Adapter\AdapterInterface;
use App\Data\User;

class UserManager
{
    public function __construct(private AdapterInterface $adapter)
    {
    }

    public function getUser(int $id): ?User
    {
        return $this->adapter->getUser($id);
    }

    public function getUsers(): array
    {
        return $this->adapter->getUsers();
    }

    public function addUser(User $user): void
    {
        $this->adapter->addUser($user);
    }

    public function updateUser(User $user): void
    {
        $this->adapter->updateUser($user);
    }

    public function deleteUser(User $user): void
    {
        $this->adapter->deleteUser($user);
    }
}
