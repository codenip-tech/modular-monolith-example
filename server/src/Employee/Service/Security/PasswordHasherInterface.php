<?php

namespace Employee\Service\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface PasswordHasherInterface
{
    public function hashPasswordForUser(PasswordAuthenticatedUserInterface $user, string $password): string;

    public function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool;
}
