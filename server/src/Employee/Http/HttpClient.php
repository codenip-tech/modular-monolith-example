<?php

declare(strict_types=1);

namespace Employee\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

final class HttpClient implements HttpClientInterface
{
    private Client $client;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->get($uri, $options);
    }
}
