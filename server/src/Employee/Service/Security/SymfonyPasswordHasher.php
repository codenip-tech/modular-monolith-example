<?php

namespace Employee\Service\Security;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SymfonyPasswordHasher implements PasswordHasherInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function hashPasswordForUser(PasswordAuthenticatedUserInterface $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
    {
        return $this->isPasswordValid($user, $plainPassword);
    }
}
