<?php

declare(strict_types=1);

namespace Employee\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $uri, array $options = []): ResponseInterface;

    public function post(string $uri, array $options = []): ResponseInterface;

    public function delete(string $uri, array $options = []): ResponseInterface;
}
