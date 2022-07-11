<?php

declare(strict_types=1);

namespace Customer\Domain\Validation\Traits;

use Customer\Domain\Exception\InvalidArgumentException;

trait AssertMinimumAgeTrait
{
    public function assertMinimumAge(int $age, int $minimumAge): void
    {
        if ($minimumAge > $age) {
            throw InvalidArgumentException::createFromMessage(\sprintf('Age has to be at least %d', $minimumAge));
        }
    }
}
