<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Data\User;

interface AdapterInterface
{
    public function getUser(int $id): ?User;

    public function getUsers(): array;

    public function addUser(User $user): void;

    public function updateUser(User $user): void;

    public function deleteUser(User $user): void;
}
