<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTestBase extends WebTestCase
{
    protected static ?AbstractBrowser $client = null;

    public function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameter('CONTENT_TYPE', 'application/json');
        }
    }

    protected function getResponseData(Response $response): array
    {
        try {
            return (array) \json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            \var_dump($e);
            throw $e;
        }
    }
}
