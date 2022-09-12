<?php

declare(strict_types=1);

namespace Rental\Entity;

class Car
{
    public function __construct(
        private readonly string $id,
        private readonly string $brand,
        private readonly string $model,
        private readonly string $color
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
