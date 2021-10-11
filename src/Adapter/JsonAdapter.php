<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Data\User;

class JsonAdapter implements AdapterInterface
{
    public function __construct(private string $file)
    {
        if (!is_file($this->file)) {
            $this->writeContent(['index' => 0, 'users' => []]);
        }
    }

    public function getUser(int $id): ?User
    {
        $content = $this->getContent();

        foreach ($content['users'] as $jsonUser) {
            if ($jsonUser['id'] === $id) {
                $user = new User();
                $user->setId($jsonUser['id']);
                $user->setFirstName($jsonUser['firstName']);
                $user->setLastName($jsonUser['lastName']);

                return $user;
            }
        }

        return null;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        $content = $this->getContent();

        $users = [];
        foreach ($content['users'] as $jsonUser) {
            $user = new User();
            $user->setId($jsonUser['id']);
            $user->setFirstName($jsonUser['firstName']);
            $user->setLastName($jsonUser['lastName']);
            $users[] = $user;
        }

        return $users;
    }

    public function addUser(User $user): void
    {
        $content = $this->getContent();
        $content['index']++;

        $user->setId($content['index']);

        $jsonUser = [
            'id' => $content['index'],
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ];

        $content['users'][] = $jsonUser;
        $this->writeContent($content);
    }

    public function updateUser(User $user): void
    {
        $content = $this->getContent();
        foreach ($content['users'] as $index => $jsonUser) {
            if ($jsonUser['id'] === $user->getId()) {
                $content['users'][$index]['firstName'] = $user->getFirstName();
                $content['users'][$index]['lastName'] = $user->getLastName();
            }
        }

        $this->writeContent($content);
    }

    public function deleteUser(User $user): void
    {
        $content = $this->getContent();
        foreach ($content['users'] as $index => $jsonUser) {
            if ($jsonUser['id'] === $user->getId()) {
                unset($content['users'][$index]);
                break;
            }
        }

        $this->writeContent($content);
    }

    private function writeContent(array $content): void
    {
        $content = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->file, $content);
    }

    private function getContent(): array
    {
        $content = file_get_contents($this->file);
        return json_decode($content, true);
    }
}
